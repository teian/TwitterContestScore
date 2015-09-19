<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Commands
 */

namespace app\commands;

use yii;
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
use TwitterAPIExchange;

/**
 * Pulls Tweets for Contests and parses them
 */
class CrawlerController extends Controller
{
    private $TwitterUrl = 'https://api.twitter.com/1.1/search/tweets.json';

    /**
     * This command first pulls all new tweets and then parses them.
     */
    public function actionIndex()
    {     
        $this->actionPulltweets();
        $this->actionProcessData();
    }

    /**
     * This command pulls new messages from twitter
     */
    public function actionPulltweets()
    {
        $this->stdout("Starting Pulltweets!\n", Console::FG_CYAN);

        $CurrentDate = new \DateTime('NOW');
        $TwitterSettings = array(
            'oauth_access_token' => Yii::$app->params["oauth_access_token"],
            'oauth_access_token_secret' => Yii::$app->params["oauth_access_token_secret"],
            'consumer_key' => Yii::$app->params["consumer_key"],
            'consumer_secret' => Yii::$app->params["consumer_secret"]
        );        
        $TwitterApi = new TwitterAPIExchange($TwitterSettings);

        $Contests = Contest::findAll([
            'active' => 1
        ]);

        foreach($Contests as $Contest) 
        {
            if($CurrentDate->format('Y-m-d') >= $Contest->parse_from && $CurrentDate->format('Y-m-d') <= $Contest->parse_to) {
                $this->stdout("Get Next Data for ".$Contest->name."!\n", Console::FG_YELLOW);

                $GetData = ''; 
                if($Contest->next_result_query != null) 
                {
                    $GetData = urldecode($Contest->next_result_query) . '&count=100';
                    $this->stdout("Exec Query: ".$GetData."!\n", Console::FG_YELLOW);
                }
                else
                {
                    $GetData = '?q=' . $Contest->trigger . '&result_type=mixed&count=100';
                    $this->stdout("First Query: ".$GetData."!\n", Console::FG_YELLOW);
                }

                // pull next results
                $TwitterData = $TwitterApi
                    ->setGetfield($GetData)
                    ->buildOauth($this->TwitterUrl, 'GET')
                    ->performRequest();

                $jsonData = Json::decode($TwitterData, true);

                // only save data if we have new results from API
                if(sizeof($jsonData["statuses"]) > 0)
                {

                    $CrawlerData = new CrawlerData;
                    $CrawlerData->contest_id = $Contest->id;
                    $CrawlerData->data = $TwitterData;

                    if($CrawlerData->save())
                    {
                        $this->stdout("Saved new Crawler Data for Contest ".$Contest->name."!\n", Console::FG_GREEN);
                    }
                    else
                    {
                        $this->stdout("Error Saving Crawler Data!\n", Console::BOLD);  
                        $this->stdout(print_r($CrawlerData->errors) . "\n", Console::BOLD);
                    }
                }

                $last_parse_date = new DateTime('NOW');
                $Contest->last_parse = $last_parse_date->format('Y-m-d H:i:s');

                if($Contest->save())
                {
                    $this->stdout("Last parse date for Contest ".$Contest->name." saved!\n", Console::FG_GREEN);
                }
                else
                {
                    $this->stdout("Error last parse date for Contest ".$Contest->name."!\n", Console::BOLD);  
                    $this->stdout(print_r($Contest->errors) . "\n", Console::BOLD);
                }
            } else {
                $this->stdout("Skipping ".$Contest->name."!\n", Console::FG_YELLOW);
            }
        }        
    }

    /**
     * This command processes the Data pulled from twitter
     */
    public function actionProcessData()
    {
        $CurrentDate = new \DateTime('NOW');
        $crawlerDataCollection = CrawlerData::findAll(['parsed_at' => null]);

        $json_data = [];        
        $regex = [];

        foreach($crawlerDataCollection as $crawlerData) 
        {
            $Contest = Contest::findOne($crawlerData->contest_id);
            $contestRegex = CrawlerProfile::findOne(['id' => $Contest->crawler_profile_id]);

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
                // Get tweet creation date
                $TweetDate = DateTime::createFromFormat("D M d H:i:s T Y", $tweet["created_at"]);
                // check if Tweet creation date is within restrictions!
                if($TweetDate->format('Y-m-d') >= $Contest->parse_from && $TweetDate->format('Y-m-d') <= $Contest->parse_to) {
                    $Tweet = $this->CreateTweetEntry($tweet, $Contest->id, $regex);

                    if($Tweet != null)
                    {
                        $Contest->last_parsed_tweet_id = $Tweet->id;                    
                    }
                }
            }
            
            if(array_key_exists("next_results", $jsonData["search_metadata"]))
            {
                $Contest->next_result_query = $jsonData["search_metadata"]["next_results"];
            }
            else
            {
                // Set new refresh URL only if we have processed new tweets
                if(sizeof($jsonData["statuses"]) > 0) {
                    $Contest->next_result_query = $jsonData["search_metadata"]["refresh_url"];
                }                
            }

            if($Contest->save())
            {
                $this->stdout("Last Tweet ID for Contest ".$Contest->name." saved!\n", Console::FG_GREEN);

                // Update Entries with new Data
                $this->UpdateContestEntries($Contest);
            }
            else
            {
                $this->stdout("Error Saving Tweet !\n", Console::BOLD);  
                $this->stdout(print_r($Contest->errors) . "\n", Console::BOLD);
            }

            $parsed_at = new DateTime('NOW');
            $crawlerData->parsed_at = $parsed_at->format('Y-m-d H:i:s');
            //save parsed_at time
            $crawlerData->save();
        }
    }

    /**
     * Removes all found votes from the voting because a newer vote has been registered
     * 
     * @param int $user_id Tweet User ID
     * @param int $entry_id Entry id to check for multiple votes
     */
    private function ExcludeOldTweetEntry($contest_id, $user_id, $entry_id, $tweet_id)
    {
        // Select old tweets of user for this entry and exlude them from the voting
        $TweetCollection = Tweet::findAll([
            'contest_id' => $contest_id, 
            'entry_id' => $entry_id, 
            'user_id' => $user_id, 
            'needs_validation' => 0, 
            'old_vote' => 0
        ]);

        foreach($TweetCollection as $Tweet) 
        {
            // don't set oldvote on given tweet id 
            if($Tweet->id != $tweet_id) {
               $Tweet->old_vote = 1;
                if($Tweet->save()) {
                    $this->stdout("Tweet with Tweet ID ".$Tweet->id." removed from Voting because of a newer Vote\n", Console::BOLD); 
                } 
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
        $min_rating = 1;
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

        // possible vote manipulation!
        if($tweet["retweeted"] == true || array_key_exists("retweeted_status", $tweet)) {
            $Tweet->needs_validation = true;
        }

        $rating = $this->ParseRating($regex["rating"], $Tweet->text);
        $entryNr = $this->ParseEntryId($regex["entry"], $Tweet->text);

        if($rating == null)
        {
            $this->stdout("Rating could not be parsed for Tweet ID ".$Tweet->id."\n", Console::FG_RED); 
            $Tweet->needs_validation = true;
        }
        else
        {
            // check if rating is inside constraints
            if($rating > $max_rating)
            {
                $this->stdout("Rating outside of constraints Tweet ID ".$Tweet->id."\n", Console::FG_RED); 
                $Tweet->rating = $max_rating;
            } 
            else if($rating < $min_rating)
            {
                $this->stdout("Rating outside of constraints Tweet ID ".$Tweet->id."\n", Console::FG_RED); 
                $Tweet->rating = $min_rating;
            }
            else
            {
                $Tweet->rating = $rating;
            }            
        }

        if($entryNr == null)
        {
            $Tweet->needs_validation = true;
        }
        else
        {
            $Entry = Entry::findOne(['contest_id' => $contest_id, 'contest_entry_id' => $entryNr]);
            
            if($Entry != null)
            {
                $Tweet->entry_id = $Entry->id;
                
                // check if we have to set a new max rating
                if($Tweet->rating > $Entry->max_rating && $Tweet->rating >= $min_rating && $Tweet->rating <= $max_rating)
                {
                    $Entry->max_rating = round($Tweet->rating, 2);
                }

                if( ($Tweet->rating < $Entry->min_rating || $Entry->min_rating == 0) 
                    && $Tweet->rating >= $min_rating 
                    && $Tweet->rating <= $max_rating
                )
                {
                    $Entry->min_rating = round($Tweet->rating, 2);
                }

                $Entry->save();

                // remove old entries vom voting
                $this->ExcludeOldTweetEntry($contest_id, $Tweet->user_id, $Entry->id, $Tweet->id);
            }
            else
            {
                $Tweet->needs_validation = true;
            }
        }         
        
        if($Tweet->validate() && $Tweet->save())
        {
            // remove old entries vom voting
            if($Tweet->needs_validation == false) {
                $this->ExcludeOldTweetEntry($Tweet->contest_id, $Tweet->user_id, $Tweet->entry_id, $Tweet->id);
            }

            $this->stdout("Tweet ID ".$Tweet->id." for Contest ID ".$contest_id." saved!\n");
            $this->stdout("Entry: ".$Tweet->entry_id.", Rating: ".$Tweet->rating."\n");            
            return $Tweet;
        }
        else
        {
            $this->stdout("Tweet already in Database! Tweet ID ".$Tweet->id."\n", Console::FG_RED);
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
            $avgQuery->from(Tweet::tableName())->where(['entry_id' => $Entry->id, 'needs_validation' => 0, 'old_vote' => 0]);
            $avgRating = $avgQuery->average('rating');

            $votestQuery = new Query;
            $votestQuery->from(Tweet::tableName())->where(['entry_id' => $Entry->id, 'needs_validation' => 0, 'old_vote' => 0]);
            $votes = $votestQuery->count();

            $Entry->votes = $votes;
            $Entry->avg_rating = round($avgRating, 2);

            $Entry->save();
        }
    }
}
