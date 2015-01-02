<?php
/*
 * Twitter Parser Command.
 * @author Frank Gehann <fg@code-works.de>
 * @copyright Copyright (c) Code Works 2014
 *
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <fg@code-works.de> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. Frank Gehann
 * ----------------------------------------------------------------------------
 */

class CrawlerCommand extends CConsoleCommand
{
	public function actionFetch() 
    {

    }

    public function actionParse() 
    {
    	$CrawlerData = new CrawlerData();

    	$data = file_get_contents("../testdata/test.json");

		$json_data = json_decode($data, true);

    	$insert_users = [];
		$insert_tweets = [];

		$min_rating = 0;
		$max_rating = 10;

		foreach($json_data["statuses"] as $id => $tweet)
		{
			// Get User Data
			$user = [];
			$user["id"] = $tweet["user"]["id_str"];
			$user["screen_name"] = $tweet["user"]["screen_name"];
			
			$tweet_user_date = date_parse($tweet["user"]["created_at"]);

			$date_string = date(
				'Y-m-d H:i:s', 
				mktime(
					$tweet_user_date['hour'], 
					$tweet_user_date['minute'], 
					$tweet_user_date['second'], 
					$tweet_user_date['month'], 
					$tweet_user_date['day'], 
					$tweet_user_date['year']
				)
			);

			$user["created_at"] = $date_string;

			$insert_users[$user["id"]] = $user;

			// Get Tweet Data

			$tweet_data = [];

			$tweet_data["id"] = $tweet["id_str"];
			$tweet_data["needs_validation"] = 0;

			$tweet_date = date_parse($tweet["created_at"]);
			$date_string = date(
				'Y-m-d H:i:s', 
				mktime(
					$tweet_date['hour'], 
					$tweet_date['minute'], 
					$tweet_date['second'], 
					$tweet_date['month'], 
					$tweet_date['day'], 
					$tweet_date['year']
				)
			);

			$tweet_data["text"] = trim($tweet["text"]);
			$tweet_data["created_at"] = $date_string;

			$tweet_data["contest_id"] = 1;

			$id_matches = [];

			if(preg_match("/ID(\d+)|ID (\d+)/mi", $tweet_data["text"], $id_matches))
			{
				$tweet_data["amv_id"] = $id_matches[sizeof($id_matches)-1]; // return last match index since php is stupid ...
			}
			else
			{
				$tweet_data["amv_id"] = -1;
				$tweet_data["needs_validation"] = 1;
			}	

			$rating_matches = [];
			if(preg_match("/Wertung:(\d+(?:[\.,]\d+)?)|Wertung: (\d+(?:[\.,]\d+)?)|Wertung :(\d+(?:[\.,]\d+)?)|Wertung : (\d+(?:[\.,]\d+)?)|Wertung (\d+(?:[\.,]\d+)?)|ID\d+ (\d+(?:[\.,]\d+)?)|ID \d+ (\d+(?:[\.,]\d+)?)/mi", $tweet_data["text"], $rating_matches))
			{
				$tweet_data["rating"] = round($rating_matches[sizeof($rating_matches)-1], 2); // return last match index since php is stupid ...

				// Rating value out of defined range?
				if($tweet_data["rating"] < $min_rating || $tweet_data["rating"] > $max_rating)
				{
					$tweet_data["needs_validation"] = 1;
				}
			}
			else
			{
				$tweet_data["rating"] = -1;
				$tweet_data["needs_validation"] = 1;
			}

			$tweet_data["user_id"] = $user["id"];

			$insert_tweets[$tweet_data["id"]] = $tweet_data;

		}

		$db = new PDO('mysql:host=localhost;dbname=amvscore;charset=utf8', 'amvscore', 'amvscore');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		try {

			$stmt = $db->query('SELECT * FROM amv WHERE contest_id = 1');

			$amv_map = [];
			$amvs_data = [];
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				// add a modified flag for later use :D
				$row["modified"] = false;
				$amv_data[$row["contest_amv_id"]] = $row;
		    }

			$stmt = $db->query('SELECT * FROM tweet_user');
			$tweet_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $ex) {
		    echo "An Error occured!"; //user friendly message
		    echo $ex->getMessage();
		}

		// first add all missing users to the DB
		$sql_insert_user = "INSERT INTO tweet_user (id,screen_name,created_at) VALUES (:id,:screen_name,:created_at)";
		$q_insert_user = $db->prepare($sql_insert_user);


		foreach($insert_users as $user)
		{
			try
			{
				$q_insert_user->execute(array(
					':id'=> $user["id"],
					':screen_name'=> $user["screen_name"],
					':created_at'=>$user["created_at"]
				));
			}
			catch(PDOException $ex) {

				if($ex->getCode() == 23000) {
			    	echo "User Bereits vorhanden!" . PHP_EOL; //user friendly message
			    } else {
			    	echo $ex->getMessage() . PHP_EOL;
			    }	    
			}

		}

		// now add all tweets
		$sql_insert_tweet = "
			INSERT INTO tweet (id,created_at,text,user_id,contest_id,amv_id,rating,needs_validation) 
			VALUES 
			(:id,:created_at,:text,:user_id,:contest_id,:amv_id,:rating,:needs_validation)
		";
		$q_insert_tweet = $db->prepare($sql_insert_tweet);

		foreach($insert_tweets as $tweet)
		{
			$isNew = true;
			try
			{
				$q_insert_tweet->execute(array(
					':id'=> $tweet["id"],
					':created_at'=>$tweet["created_at"],
					':text'=>$tweet["text"],
					':contest_id'=>$tweet["contest_id"],
					':user_id'=>$tweet["user_id"],
					':amv_id'=> isset($amv_data[$tweet["amv_id"]]) ? $amv_data[$tweet["amv_id"]]["id"]: -1,
					':rating'=>$tweet["rating"],
					':needs_validation'=>$tweet["needs_validation"]		
				));
			}
			catch(PDOException $ex) {
				if($ex->getCode() == 23000) {
					$isNew = false;
			    	echo "Tweet Bereits vorhanden!" . PHP_EOL; //user friendly message
			    } else {
			    	echo $ex->getMessage() . PHP_EOL;
			    }	
			}

			// check if it's a new entry and and amv is present in the db and then edit the min/max value data
			if($isNew && !$tweet["needs_validation"] && isset($amv_data[$tweet["amv_id"]]))
			{
				$amvid = $tweet["amv_id"];

				// set the modified flag so whe know which amvs need a db update =)
				$amv_data[$amvid]["modified"] = true;
				$amv_data[$amvid]["max_rating"] = ($tweet["rating"] > $amv_data[$amvid]["max_rating"] && $tweet["rating"] >= $min_rating && $tweet["rating"] <= $max_rating) ? round($tweet["rating"], 2) : $amv_data[$amvid]["max_rating"];
				$amv_data[$amvid]["min_rating"] = (($tweet["rating"] < $amv_data[$amvid]["min_rating"] || $amv_data[$amvid]["min_rating"] == 0) && $tweet["rating"] >= $min_rating && $tweet["rating"] <= $max_rating) ? round($tweet["rating"]) : $amv_data[$amvid]["min_rating"];
				$amv_data[$amvid]["sum_rating"] += $tweet["rating"];
				$amv_data[$amvid]["votes"]++;
			}
		}

		// update amv data
		$sql_update_amv = "
			UPDATE amv 
			SET avg_rating=:avg_rating, max_rating=:max_rating, min_rating=:min_rating, sum_rating=:sum_rating, votes=:votes
			WHERE id=:id
		";
		$q_update_amv = $db->prepare($sql_update_amv);

		foreach($amv_data as $amv)
		{
			if($amv["modified"])
			{
				try
				{
					$q_update_amv->execute(array(
						':avg_rating'=> round(($amv["sum_rating"] / $amv["votes"]), 2),
						':max_rating'=>$amv["max_rating"],
						':min_rating'=>$amv["min_rating"],
						':sum_rating'=>$amv["sum_rating"],
						':votes' => $amv["votes"],
						':id' => $amv["id"],	
					));
				}
				catch(PDOException $ex) {
					if($ex->getCode() == 23000) {
						$isNew = false;
				    	echo "Tweet Bereits vorhanden!" . PHP_EOL; //user friendly message
				    } else {
				    	echo $ex->getMessage() . PHP_EOL;
				    }	
				}
			}
		}
    }
}

?>