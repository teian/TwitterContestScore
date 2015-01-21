<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware License
 * @package Commands
 */

namespace app\commands;

use yii\console\Controller;

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
        $contestData = \app\models\CrawlerData::findAll([
            'parsed_at' => null,
        ]);

        print_r($contestData);

        /*

        $min_rating = 0;
        $max_rating = 10;

        foreach($json_data["statuses"] as $id => $tweet)
        {
            $CreateDate = DateTime::createFromFormat("D M d H:i:s T Y", $tweet["created_at"]);

            // check if we have user in our db if not create one
            $TweetUser = $this->GetOrAddUser($tweet["user"]);
        
            // Create new Tweet object
            $Tweet = new \app\models\Tweet;
            
            $Tweet->id = $tweet["id_str"]; 
            $Tweet->created_at = $CreateDate->format('Y-m-d H:i:s');
            $Tweet->text = trim($tweet["text"]);
            $Tweet->user_id = $TweetUser->id;
            $Tweet->contest_id = 1;
            $Tweet->entry_id = $this->ParseEntryId("REGEX", $Tweet->text);
            $Tweet->rating = $this->ParseEntryId("REGEX", $Tweet->text);
            $Tweet->needs_validation = false;

            if($Tweet->rating < 0 || $Tweet->rating < $min_rating || $Tweet->rating > $max_rating)
            {
                $Tweet->needs_validation = true;
            }
        }
        */
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
        $Matches = [];

        if(preg_match($regex, tweet, $Matches))
        {
            return $Matches[sizeof($Matches)-1]; // return last match index since php is stupid ...
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
        $Matches = [];   

        if(preg_match($regex, $tweet, $Matches))
        {
            return round($rating_matches[sizeof($rating_matches)-1], 2); // return last match index since php is stupid ...
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
