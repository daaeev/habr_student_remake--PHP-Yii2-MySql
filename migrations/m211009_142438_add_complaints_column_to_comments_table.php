<?php

use yii\db\Migration;

class m211009_142438_add_complaints_column_to_comments_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('comments', 'complaints', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('comments', 'complaints');
    }
}
