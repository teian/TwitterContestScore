<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_205656_update_contest_table extends Migration
{
    public function safeUp()
    {
        // modify contest table
        $this->addColumn('{{%contest}}', 'next_result_query', Schema::TYPE_STRING ." DEFAULT NULL AFTER custom_regex_rating");
    }

    public function safeDown()
    {
        $this->dropColumn('{{%contest}}', 'next_result_query');
    }
}
