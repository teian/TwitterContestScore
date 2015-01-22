<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware License
 * @package Commands
 */

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;

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
    public function actionPullTweets()
    {
        $CurrentDate = new DateTime('NOW');

        $contests = Contest::findAll([
            'active' => 1,
            'parse_from' => '<=' . $CurrentDate->format('Y-m-d'),
            'parse_to' => '>=' . $CurrentDate->format('Y-m-d'),
        ]);

        foreach($contests as $contest) 
        {
            print_r($contest);
        }        
    }

    /**
     * This command processes the Data pulled from twitter
     */
    public function actionProcess()
    {
        $defaultRegex = \app\models\CrawlerProfile::findOne(['is_default' => 1]);
        $crawlerDataCollection = \app\models\CrawlerData::findAll(['parsed_at' => null]);

        $min_rating = 0;
        $max_rating = 10;

        $json_data = [];        
        $regex = [];

        foreach($crawlerDataCollection as $crawlerData) 
        {
            $contest = \app\models\Contest::findOne($crawlerData->contest_id);

            if($contest->custom_regex_entry == null)
            {
                $regex["entry"] = $defaultRegex->regex_entry;
            }
            else
            {
                $regex["entry"] = $contest->custom_regex_entry;
            }

            if($contest->custom_regex_rating == null)
            {
                $regex["rating"] = $defaultRegex->regex_rating;
            }    
            else
            {
                $regex["rating"] = $contest->custom_regex_rating;
            }        

            $jsonData = \yii\helpers\Json::decode($crawlerData->data, true);

            foreach($jsonData["statuses"] as $id => $tweet)
            {
                $TweetUser = $this->GetOrAddUser($tweet["user"]);
                $CreateDate = \DateTime::createFromFormat("D M d H:i:s T Y", $tweet["created_at"]);
            
                // Create new Tweet object
                $Tweet = new \app\models\Tweet;                
                $Tweet->id = $tweet["id_str"]; 
                $Tweet->created_at = $CreateDate->format('Y-m-d H:i:s');
                $Tweet->text = trim($tweet["text"]);
                $Tweet->user_id = $TweetUser->id;
                $Tweet->contest_id = $crawlerData->contest_id;
                $Tweet->entry_id = $this->ParseEntryId($regex["entry"], $Tweet->text);
                $Tweet->rating = $this->ParseRating($regex["rating"], $Tweet->text);
                $Tweet->needs_validation = false;

                if($Tweet->entry_id < 0)
                {
                    $Tweet->needs_validation = true;
                }

                if($Tweet->rating < 0 || $Tweet->rating < $min_rating || $Tweet->rating > $max_rating)
                {
                    $Tweet->needs_validation = true;
                }  
                
                if($Tweet->save())
                {
                    $this->stdout("Tweet ID ".$Tweet->id." for Contest ".$contest->name." saved!\n");
                    $this->stdout("Entry: ".$Tweet->entry_id.", Rating: ".$Tweet->rating."\n");
                    $contest->last_parsed_tweet_id = $Tweet->id;
                }
                else
                {
                    $this->stdout("Error Saving Tweet", Console::BOLD);
                }
            }

            if($contest->save())
            {
                $this->stdout("Last Tweet ID for Contest ".$contest->name." saved!\n", Console::BOLD);
            }
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
            return -1;
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
            return -1;
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
        $TweetUser = \app\models\TweetUser::findOne($user["id_str"]);

        if($TweetUser != null)
        {
            $TweetUser->screen_name = $user["screen_name"];
        }
        else
        {
            $TweetUser = new \app\models\TweetUser;
            $TweetUser->id = $user["id_str"];
            $TweetUser->screen_name = $user["screen_name"];
            $TweetUser->save();
        }

        return $TweetUser;
    }
}
