<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_205656_update_contest_table extends Migration
{
    public function up()
    {
        // modify contest table
        $this->addColumn('{{%contest}}', 'next_result_query', Schema::TYPE_STRING ." DEFAULT NULL AFTER custom_regex_rating");
    }

    public function down()
    {
        echo "m150825_205656_update_contest_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
