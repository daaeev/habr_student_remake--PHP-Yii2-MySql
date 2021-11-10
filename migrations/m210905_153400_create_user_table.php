<?php

use yii\db\Migration;

class m210905_153400_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'image' => $this->string(),
            'email' => $this->string(),
            'password' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(0),
            'ban_reason' => $this->text(),
            'contribution' => $this->integer()->defaultValue(0),
            'can_ask_time' => $this->bigInteger()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
