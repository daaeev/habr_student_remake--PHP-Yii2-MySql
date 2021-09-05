<?php

use yii\db\Migration;

class m210905_113207_create_tags_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'tag_name' => $this->string(),
            'tag_image' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%tags}}');
    }
}
