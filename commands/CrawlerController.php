<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Commands
 */

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Json;
use yii\db\Query;
use app\models\CrawlerProfile;
use app\models\CrawlerData;
use app\models\Contest;
use app\models\Tweet;
use app\models\TweetUser;
use app\models\Entry;
use \Datetime;

/**
 * Pulls Tweets for Contests and parses them
 */
class CrawlerController extends Controller
{
    /**
     * This command first pulls all new tweets and then parses them.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        
    }

    /**
     * This command pulls new messages from twitter
     */
    public function actionPulltweets()
    {
        $CurrentDate = new \DateTime('NOW');

        $Contests = Contest::findAll([
            'active' => 1,
            //'parse_from' => '<=' . $CurrentDate->format('Y-m-d'),
            //'parse_to' => '>=' . $CurrentDate->format('Y-m-d'),
        ]);

        foreach($Contests as $Contest) 
        {
            $this->UpdateContestEntries($Contest);
        }        
    }

    /**
     * This command processes the Data pulled from twitter
     */
    public function actionProcess()
    {
        $crawlerDataCollection = CrawlerData::findAll(['parsed_at' => null]);

        $json_data = [];        
        $regex = [];

        foreach($crawlerDataCollection as $crawlerData) 
        {
            $Contest = Contest::findOne($crawlerData->contest_id);
            $contestRegex = CrawlerProfile::findOne(['id' => $crawlerData->crawler_profile_id]);

            if($Contest->custom_regex_entry == null)
            {
                $regex["entry"] = $contestRegex->regex_entry;
            }
            else
            {
                $regex["entry"] = $Contest->custom_regex_entry;
            }

            if($Contest->custom_regex_rating == null)
            {
                $regex["rating"] = $contestRegex->regex_rating;
            }    
            else
            {
                $regex["rating"] = $Contest->custom_regex_rating;
            }        

            $jsonData = Json::decode($crawlerData->data, true);

            foreach($jsonData["statuses"] as $id => $tweet)
            {
                $Tweet = $this->CreateTweetEntry($tweet, $Contest->id, $regex);

                if($Tweet != null)
                {
                    $Contest->last_parsed_tweet_id = $Tweet->id;                    
                }
            }

            $last_parse_date = new DateTime('NOW');
            $Contest->last_parse = $last_parse_date->format('Y-m-d H:i:s');

            if($Contest->save())
            {
                $this->stdout("Last Tweet ID for Contest ".$Contest->name." saved!\n", Console::FG_GREEN);
            }
            else
            {
                $this->stdout("Error Saving Tweet!\n", Console::BOLD);  
                $this->stdout(print_r($Contest->errors) . "\n", Console::BOLD);
            }
        }
    }

    /**
     * Creates a Tweet Object and saves it to the DB 
     * 
     * @param Array $tweet JSON Tweet structure
     * @param Array $regex regular expression to parse the rating and Entry - http://regex101.com/r/cB6oU6/7
     * @return int id of the tweet or null if an error happened
     */
    private function CreateTweetEntry($tweet, $contest_id, $regex)
    {
        $min_rating = 0;
        $max_rating = 10;

        $TweetUser = $this->GetOrAddUser($tweet["user"]);
        $CreateDate = DateTime::createFromFormat("D M d H:i:s T Y", $tweet["created_at"]);
    
        // Create new Tweet object
        $Tweet = new Tweet;                
        $Tweet->id = $tweet["id_str"]; 
        $Tweet->created_at = $CreateDate->format('Y-m-d H:i:s');
        $Tweet->text = trim($tweet["text"]);
        $Tweet->user_id = $TweetUser->id;
        $Tweet->contest_id = $contest_id;        
        $Tweet->needs_validation = false;

        $rating = $this->ParseRating($regex["rating"], $Tweet->text);
        $entryNr = $this->ParseEntryId($regex["entry"], $Tweet->text);

        if($rating == null || $rating < $min_rating || $rating > $max_rating)
        {
            $Tweet->needs_validation = true;
        } 
        else
        {
            $Tweet->rating = $rating;
        }

        if($entryNr == null)
        {
            $Tweet->needs_validation = true;
        }
        else
        {
            $Entry = Entry::findOne(['contest_id' => 1, 'contest_entry_id' => $entryNr]);
            
            if($Entry != null)
            {
                $Tweet->entry_id = $Entry->id;

                // Save new Entry stats if inside constraints
                if($Tweet->rating > $Entry->max_rating && $Tweet->rating >= $min_rating && $Tweet->rating <= $max_rating)
                {
                    $Entry->max_rating = round($Tweet->rating, 2);
                }

                if($Tweet->rating > $Entry->min_rating && $Tweet->rating >= $min_rating && $Tweet->rating <= $max_rating)
                {
                    $Entry->min_rating = round($Tweet->rating, 2);
                }

                $Entry->save();
            }
            else
            {
                $Tweet->needs_validation = true;
            }
        }        
        
        if($Tweet->validate() && $Tweet->save())
        {
            $this->stdout("Tweet ID ".$Tweet->id." for Contest ID ".$contest_id." saved!\n");
            $this->stdout("Entry: ".$Tweet->entry_id.", Rating: ".$Tweet->rating."\n");
            
            return $Tweet;
        }
        else
        {
            $this->stdout("Error Saving Tweet!\n", Console::FG_RED);
            $this->stdout(print_r($Tweet->errors) . "\n", Console::FG_RED);

            return null;
        }   
    }

    /**
     * Parses the Entry Id from the Tweet text
     * 
     * @param string $regex regular expression to parse the rating - http://regex101.com/r/cB6oU6/7
     * @param string $tweet tweet text
     * @return int id of the entry or -1 if it could not be parsed
     */
    private function ParseEntryId($regex, $tweet)
    {
        $matches = [];
        if(preg_match("/".$regex."/mi", $tweet, $matches))
        {
            return $matches[sizeof($matches)-1]; // return last match index since php is stupid ...
        }
        else
        {
            return null;
        }   
    }

    /**
     * Parses the Entry Id from the Tweet text
     * 
     * @param string $regex regular expression to parse the rating - http://regex101.com/r/cB6oU6/7
     * @param string $tweet tweet text
     * @return int id of the entry or -1 if it could not be parsed
     */
    private function ParseRating($regex, $tweet)
    {
        $matches = [];
        if(preg_match("/".$regex."/mi", $tweet, $matches))
        {
            return round($matches[sizeof($matches)-1], 2); // return last match index since php is stupid ...
        }
        else
        {
            return null;
        } 
    }

    /**
     * Pulls the TweetUser From DB or Adds a new one
     * 
     * @param mixed $user Array with the Userdata from the tweet
     * @return \app\models\TweetUser
     */
    private function GetOrAddUser($user)
    {
        $TweetUser = TweetUser::findOne($user["id_str"]);

        if($TweetUser != null)
        {
            $TweetUser->screen_name = $user["screen_name"];
        }
        else
        {
            $TweetUser = new TweetUser;
            $TweetUser->id = $user["id_str"];
            $TweetUser->screen_name = $user["screen_name"];
            $TweetUser->save();
        }

        return $TweetUser;
    }

    /**
     * Updates all Entries of a Contest with votecount and avg rating
     * 
     * @param \app\models\Contest $Contest Contest Object
     */
    private function UpdateContestEntries($Contest)
    {
        $Entries = Entry::findAll(['contest_id' => $Contest->id]);
            
        foreach($Entries as $Entry) 
        {
            $avgQuery = new Query;
            $avgQuery->from(Tweet::tableName())->where(['entry_id' => $Entry->id]);
            $avgRating = $avgQuery->average('rating');

            $votestQuery = new Query;
            $votestQuery->from(Tweet::tableName())->where(['entry_id' => $Entry->id]);
            $votes = $votestQuery->count();

            $Entry->votes = $votes;
            $Entry->avg_rating = round($avgRating, 2);

            $Entry->save();
        }
    }
}
