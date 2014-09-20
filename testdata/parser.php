<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<?php

$data = file_get_contents("test.json");

$json_data = json_decode($data, true);


$insert_users = array();
$insert_tweets = array();

echo "<pre>";

foreach($json_data["statuses"] as $id => $tweet)
{
	// Get User Data
	$user = array();
	$user["id"] = $tweet["user"]["id_str"];
	$user["screen_name"] = $tweet["user"]["screen_name"];
	
	$date_array = date_parse($tweet["user"]["created_at"]);
	$date_string = date('Y-m-d H:i:s', mktime($date_array['hour'], $date_array['minute'], $date_array['second'], $date_array['month'], $date_array['day'], $date_array['year']));

	$user["created_at"] = $date_string;

	$insert_users[$user["id"]] = $user;

	// Get Tweet Data

	$tweet_data = array();

	$tweet_data["id"] = $tweet["id_str"];

	$tweet_data["needs_validation"] = 0;

	$date_array = date_parse($tweet["created_at"]);
	$date_string = date('Y-m-d H:i:s', mktime($date_array['hour'], $date_array['minute'], $date_array['second'], $date_array['month'], $date_array['day'], $date_array['year']));

	$tweet_data["text"] = trim($tweet["text"]);

	$tweet_data["created_at"] = $date_string;

	$tweet_data["contest_id"] = 1;

	$id_matches = array();

	if(preg_match("/ID(\d+)|ID (\d+)/mi", $tweet_data["text"], $id_matches))
	{
		$tweet_data["amv_id"] = $id_matches[sizeof($id_matches)-1]; // return last match index since php is stupid ...
	}
	else
	{
		$tweet_data["amv_id"] = -1;
		$tweet_data["needs_validation"] = 1;
	}	

	$rating_matches = array();
	if(preg_match("/Wertung:(\d+)|Wertung: (\d+)|Wertung :(\d+)|Wertung : (\d+)|Wertung (\d+)|ID\d+ (\d+)|ID \d+ (\d+)/mi", $tweet_data["text"], $rating_matches))
	{
		$tweet_data["rating"] = $rating_matches[sizeof($rating_matches)-1]; // return last match index since php is stupid ...
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

	$amv_map = array();
	$amvs_data = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $amv_map[$row["contest_amv_id"]] = $row["id"];
      $amvs_data[$row["id"]] = $row;
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
	try
	{
		$q_insert_tweet->execute(array(
			':id'=> $tweet["id"],
			':created_at'=>$tweet["created_at"],
			':text'=>$tweet["text"],
			':contest_id'=>$tweet["contest_id"],
			':user_id'=>$tweet["user_id"],
			':amv_id'=> isset($amv_map[$tweet["amv_id"]]) ? $amv_map[$tweet["amv_id"]]: -1,
			':rating'=>$tweet["rating"],
			':needs_validation'=>$tweet["needs_validation"]		
		));
	}
	catch(PDOException $ex) {
		if($ex->getCode() == 23000) {
	    	echo "Tweet Bereits vorhanden!" . PHP_EOL; //user friendly message
	    } else {
	    	echo $ex->getMessage() . PHP_EOL;
	    }	
	}
}

echo "</pre>";

?>
</body>
</html>