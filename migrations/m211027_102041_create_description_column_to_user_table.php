<?php

use yii\db\Migration;

class m211027_102041_create_description_column_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'description', $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'description');
    }
}
