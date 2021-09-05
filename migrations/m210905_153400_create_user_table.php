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
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
