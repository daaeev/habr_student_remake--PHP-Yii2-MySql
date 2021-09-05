<?php

use yii\db\Migration;

class m210905_155534_create_user_to_tag_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user_to_tag_sub}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);
        
        $this->createIndex(
            'idx-user_to_tag_sub-user_id',
            'user_to_tag_sub',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_to_tag_sub-user_id',
            'user_to_tag_sub',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
          
        $this->createIndex(
            'idx-user_to_tag_sub-tag_id',
            'user_to_tag_sub',
            'tag_id'
        );

        $this->addForeignKey(
            'fk-user_to_tag_sub-tag_id',
            'user_to_tag_sub',
            'tag_id',
            'tags',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user_to_tag_sub-tag_id',
            'user_to_tag_sub'
        );

        $this->dropIndex(
            'idx-user_to_tag_sub-tag_id',
            'user_to_tag_sub'
        );

        $this->dropForeignKey(
            'fk-user_to_tag_sub-user_id',
            'user_to_tag_sub'
        );

        $this->dropIndex(
            'idx-user_to_tag_sub-user_id',
            'user_to_tag_sub'
        );

        $this->dropTable('{{%user_to_tag_sub}}');
    }
}
