<?php

class m150101_193620_init extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        // create amv table
        $this->createTable('amv', array(
            'id' => "bigint(20) NOT NULL",
            'contest_id' => "bigint(20) NOT NULL",
            'contest_amv_id' => "bigint(20) NOT NULL",
            'avg_rating' => "decimal(4,2) NOT NULL DEFAULT '0.00' COMMENT 'average vote'",
            'min_rating' => "decimal(4,2) NOT NULL DEFAULT '0.00' COMMENT 'lowest vote'",
            'max_rating' => "decimal(4,2) NOT NULL DEFAULT '0.00' COMMENT 'highest vote'",
            'max_rating' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'sum of all votes to easier calculate the avg later'",
            'votes' => "bigint(20) NOT NULL DEFAULT '0'",
        ));
        $this->addPrimaryKey('pk_amv', 'amv', 'id');
        $this->createIndex('unique_contest_amv', 'amv', ['contest_id', 'contest_amv_id'], true);

        // create contest table
        $this->createTable('contest', array(
            'id' => "bigint(20) NOT NULL",
            'name' => "varchar(255) NOT NULL",
            'trigger' => "varchar(255) NOT NULL",
            'year' => "varchar(4) NOT NULL",
            'active' => "tinyint(1) NOT NULL DEFAULT '0'",
            'last_parsed_tweet_id' => "bigint(20) NOT NULL",
            'last_parse' => "datetime NOT NULL",
            'parse_from' => "date NOT NULL",
            'parse_to' => "date NOT NULL",
            'crawler_profile_id' => "bigint(20) DEFAULT '1'",
            'custom_regex_id' => "text",
            'custom_regex_rating' => "text",
        ));
        $this->addPrimaryKey('pk_contest', 'contest', 'id');

        // create crawler_data table
        $this->createTable('crawler_data', array(
            'id' => "bigint(20) NOT NULL",
            'contest_id' => "bigint(20) NOT NULL",
            'data' => "text",
            'pulled_at' => "datetime NOT NULL",
            'parsed_at' => "datetime NOT NULL",
        ));
        $this->addPrimaryKey('pk_crawler_data', 'crawler_data', 'id');

        // create crawler profile table
        $this->createTable('crawler_profile', array(
            'id' => "bigint(20) NOT NULL",
            'name' => "varchar(255) NOT NULL",
            'regex_id' => "text",
            'regex_rating' => "text",
            'is_default' => "tinyint(1) NOT NULL DEFAULT '0'",
        ));
        $this->addPrimaryKey('pk_crawler_profile', 'crawler_profile', 'id');

        // Insert default crawler profile
        $this->insert('crawler_profile', [
            'id' => 1,
            'name' => 'Default',
            'regex_id' => 'ID(\d+)|ID (\d+)|ID:(\d+)|ID (\d+)',
            'regex_rating' => 'Rating:(\d+(?:[\.,]\d+)?)|Rating: (\d+(?:[\.,]\d+)?)|Rating :(\d+(?:[\.,]\d+)?)|Rating : (\d+(?:[\.,]\d+)?)|Rating (\d+(?:[\.,]\d+)?)|ID\d+ (\d+(?:[\.,]\d+)?)|ID \d+ (\d+(?:[\.,]\d+)?)',
            'is_default' => 1,
        ]);

        // create tweet table
        $this->createTable('tweet', array(
            'id' => "bigint(20) NOT NULL",
            'created_at' => "datetime NOT NULL",
            'text' => "varchar(140) NOT NULL",
            'user_id' => "bigint(20) NOT NULL",
            'contest_id' => "bigint(20) NOT NULL",
            'amv_id' => "bigint(20) NOT NULL",
            'rating' => "decimal(4,2) NOT NULL DEFAULT '0.00'",
            'needs_validation' => "tinyint(1) NOT NULL DEFAULT '0'",
        ));
        $this->addPrimaryKey('pk_tweet', 'tweet', 'id');

        // create tweet_user table
        $this->createTable('tweet_user', array(
            'id' => "bigint(20) NOT NULL",
            'screen_name' => "varchar(255) NOT NULL",
            'created_at' => "datetime NOT NULL",
        ));
        $this->addPrimaryKey('pk_tweet_user', 'tweet_user', 'id');

        // create tweet_user table
        $this->createTable('user', array(
            'id' => "bigint(20) NOT NULL",
            'username' => "varchar(45) NOT NULL",
            'password' => "varchar(255) NOT NULL",
            'salt' => "varchar(255) NOT NULL",
            'password_strategy' => "varchar(50) NOT NULL",
            'requires_new_password' => "tinyint(1) DEFAULT '0'",
            'email' => "varchar(255) NOT NULL",
            'validation_key' => "varchar(255) DEFAULT NULL",
            'login_attempts' => "int(11) DEFAULT '0'",
            'super_admin' => "int(1) NOT NULL DEFAULT '0'",
        ));
        $this->addPrimaryKey('pk_user', 'user', 'id');
        $this->createIndex('unique_user_username', 'user', 'username', true);
        $this->createIndex('unique_user_email', 'user', 'email', true);

        // add foreign key constraints for table amv
        $this->addForeignKey(
            'fk_amv_contest_id', 
            'amv', 
            'contest_id', 
            'contest', 
            'id'
        );

        // add foreign key constraints for table contest
        $this->addForeignKey(
            'fk_contest_crawler_profile_id', 
            'contest', 
            'crawler_profile_id', 
            'crawler_profile', 
            'id'
        );

        $this->addForeignKey(
            'fk_contest_last_parsed_tweet_id', 
            'contest', 
            'last_parsed_tweet_id', 
            'tweet', 
            'id'
        );

        // add foreign key constraints for table crawler_data
        $this->addForeignKey(
            'fk_crawler_data_contest_id', 
            'crawler_data', 
            'contest_id', 
            'contest', 
            'id'
        );

        // add foreign key constraints for table tweet
        $this->addForeignKey(
            'fk_tweet_contest_id', 
            'tweet', 
            'contest_id', 
            'contest', 
            'id',
            NULL, 
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_tweet_user_id', 
            'tweet', 
            'user_id', 
            'tweet_user', 
            'id',
            NULL, 
            'CASCADE'
        );

        // Insert superuser
        $user = new User();
        $user->id = 1;
        $user->username = "admin";
        $user->password = "admin123";
        $user->email = "admin@amvscore.net";
        $user->super_admin = 1;
        $user->login_attempts = 0;
        $user->save();

        echo "A Superuser has been created with the following credentials:\n";
        echo "Username: admin\n";
        echo "Password: admin123\n";
    }

    public function safeDown()
    {
        echo "No downgrade avaiable from the init migration!";
        return false;
    }
}