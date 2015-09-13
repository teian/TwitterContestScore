<?php

use yii\db\Schema;
use yii\db\Migration;

class m150913_205000_add_old_vote extends Migration
{
    public function safeUp()
    {
        // modify tweet table
        $this->addColumn('{{%tweet}}', 'old_vote', Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT 0 AFTER needs_validation");
    }

    public function safeDown()
    {
        $this->dropColumn('{{%tweet}}', 'old_vote');
    }
}
