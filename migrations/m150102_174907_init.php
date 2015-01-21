<?php

use yii\db\Schema;
use yii\db\Migration;

class m150102_174907_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

    	// create amv table
        $this->createTable('{{%entry}}', [
            'id' => Schema::TYPE_BIGPK,
            'contest_id' => Schema::TYPE_BIGINT ." NOT NULL",
            'contest_entry_id' => Schema::TYPE_BIGINT ." NOT NULL",
            'avg_rating' => Schema::TYPE_DECIMAL ."(4,2) NOT NULL DEFAULT 0.00",
            'min_rating' => Schema::TYPE_DECIMAL ."(4,2) NOT NULL DEFAULT 0.00",
            'max_rating' => Schema::TYPE_DECIMAL ."(4,2) NOT NULL DEFAULT 0.00",
            'max_rating' => Schema::TYPE_DECIMAL ."(4,2) NOT NULL DEFAULT 0.00",
            'votes' => Schema::TYPE_BIGINT ." NOT NULL DEFAULT 0",
            'create_time' => Schema::TYPE_DATETIME,
            'update_time' => Schema::TYPE_DATETIME,
        ], $tableOptions);
        $this->createIndex('unique_contest_entry', '{{%entry}}', ['contest_id', 'contest_entry_id'], true);

        // create contest table
        $this->createTable('{{%contest}}', [
            'id' => Schema::TYPE_BIGPK,
            'name' => Schema::TYPE_STRING ." NOT NULL",
            'trigger' => Schema::TYPE_STRING ." NOT NULL",
            'year' => Schema::TYPE_STRING ."(4) NOT NULL",
            'active' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT 0",
            'last_parsed_tweet_id' => Schema::TYPE_BIGINT ." DEFAULT NULL",
            'last_parse' => Schema::TYPE_DATETIME ." NOT NULL",
            'parse_from' => Schema::TYPE_DATE ." NOT NULL",
            'parse_to' => Schema::TYPE_DATE ." NOT NULL",
            'crawler_profile_id' => Schema::TYPE_BIGINT ." DEFAULT 1",
            'custom_regex_id' => Schema::TYPE_TEXT,
            'custom_regex_rating' => Schema::TYPE_TEXT,
            'create_time' => Schema::TYPE_DATETIME,
            'update_time' => Schema::TYPE_DATETIME,
        ], $tableOptions);

        // create crawler_data table
        $this->createTable('{{%crawler_data}}', [
            'id' => Schema::TYPE_BIGPK,
            'contest_id' => Schema::TYPE_BIGINT ." NOT NULL",
            'data' => Schema::TYPE_TEXT,
            'parsed_at' => Schema::TYPE_DATETIME . " DEFAULT NULL",
            'create_time' => Schema::TYPE_DATETIME,
            'update_time' => Schema::TYPE_DATETIME,
        ], $tableOptions);

        // create crawler profile table
        $this->createTable('{{%crawler_profile}}', [
            'id' => Schema::TYPE_BIGPK,
            'name' => Schema::TYPE_STRING . " NOT NULL",
            'regex_id' => Schema::TYPE_TEXT,
            'regex_rating' => Schema::TYPE_TEXT,
            'is_default' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT 0",
            'create_time' => Schema::TYPE_DATETIME,
            'update_time' => Schema::TYPE_DATETIME,
        ], $tableOptions);

        // Insert default crawler profile
        $this->insert('{{%crawler_profile}}', [
            'id' => 1,
            'name' => 'Default',
            'regex_id' => 'ID(\d+)|ID (\d+)|ID:(\d+)|ID (\d+)',
            'regex_rating' => 'Rating:(\d+(?:[\.,]\d+)?)|Rating: (\d+(?:[\.,]\d+)?)|Rating :(\d+(?:[\.,]\d+)?)|Rating : (\d+(?:[\.,]\d+)?)|Rating (\d+(?:[\.,]\d+)?)|ID\d+ (\d+(?:[\.,]\d+)?)|ID \d+ (\d+(?:[\.,]\d+)?)',
            'is_default' => 1,
        ], $tableOptions);

        // create tweet table
        $this->createTable('{{%tweet}}', [
            'id' => Schema::TYPE_BIGPK,
            'created_at' => Schema::TYPE_DATETIME . " NOT NULL",
            'text' => Schema::TYPE_STRING . " NOT NULL",
            'user_id' => Schema::TYPE_BIGINT ." NOT NULL",
            'contest_id' => Schema::TYPE_BIGINT ." NOT NULL",
            'entry_id' => Schema::TYPE_BIGINT ." NOT NULL",
            'rating' => Schema::TYPE_DECIMAL ."(4,2) NOT NULL DEFAULT '0.00'",
            'needs_validation' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT 0",
            'create_time' => Schema::TYPE_DATETIME,
            'update_time' => Schema::TYPE_DATETIME,
        ], $tableOptions);

        // create tweet_user table
        $this->createTable('{{%tweet_user}}', [
            'id' => Schema::TYPE_BIGPK,
            'screen_name' => Schema::TYPE_STRING . " NOT NULL",
            'create_time' => Schema::TYPE_DATETIME,
            'update_time' => Schema::TYPE_DATETIME,
        ], $tableOptions);

        // create tweet_user table
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_BIGPK,
            'username' => Schema::TYPE_STRING . " NOT NULL",
            'auth_key' => Schema::TYPE_STRING . "(32) NOT NULL",
            'password_hash' => Schema::TYPE_STRING . " NOT NULL",
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . " NOT NULL",
            'status' => Schema::TYPE_SMALLINT . " NOT NULL DEFAULT 10",
            'create_time' => Schema::TYPE_DATETIME,
            'update_time' => Schema::TYPE_DATETIME,
        ], $tableOptions);
        $this->createIndex('unique_user_username', '{{%user}}', 'username', true);
        $this->createIndex('unique_user_email', '{{%user}}', 'email', true);

        // add foreign key constraints for table entry
        $this->addForeignKey(
            'fk_entry_contest_id', 
            '{{%entry}}', 
            'contest_id', 
            '{{%contest}}', 
            'id'
        );

        // add foreign key constraints for table contest
        $this->addForeignKey(
            'fk_contest_crawler_profile_id', 
            '{{%contest}}', 
            'crawler_profile_id', 
            '{{%crawler_profile}}', 
            'id'
        );

        $this->addForeignKey(
            'fk_contest_last_parsed_tweet_id', 
            '{{%contest}}', 
            'last_parsed_tweet_id', 
            '{{%tweet}}', 
            'id'
        );

        // add foreign key constraints for table crawler_data
        $this->addForeignKey(
            'fk_crawler_data_contest_id', 
            '{{%crawler_data}}', 
            'contest_id', 
            '{{%contest}}', 
            'id'
        );

        // add foreign key constraints for table tweet
        $this->addForeignKey(
            'fk_tweet_contest_id', 
            '{{%tweet}}', 
            'contest_id', 
            '{{%contest}}', 
            'id',
            NULL, 
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_tweet_user_id', 
            '{{%tweet}}', 
            'user_id', 
            '{{%tweet_user}}', 
            'id',
            NULL, 
            'CASCADE'
        );

        // Insert superuser
        $user = new \app\models\User; 
        $user->username = "admin";
        $user->setPassword("admin123");
        $user->email = "admin@amvscore.net";
        $user->generateAuthKey();
        $user->save();

        echo "A Superuser has been created with the following credentials:\n";
        echo "Username: admin\n";
        echo "Password: admin123\n";
    }

    public function down()
    {
        $this->dropTable('{{%entry}}');
        $this->dropTable('{{%contest}}');
        $this->dropTable('{{%crawler_data}}');
        $this->dropTable('{{%crawler_profile}}');
        $this->dropTable('{{%tweet}}');
        $this->dropTable('{{%tweet_user}}');
        $this->dropTable('{{%user}}');
    }
}
