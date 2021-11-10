<?php

use yii\db\Migration;

class m211009_121055_create_user_to_comment_complaint_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%user_to_comment_complaint}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'comment_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-user_to_comment_complaint-user_id',
            'user_to_comment_complaint',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_to_comment_complaint-user_id',
            'user_to_comment_complaint',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_to_comment_complaint-comment_id',
            'user_to_comment_complaint',
            'comment_id'
        );

        $this->addForeignKey(
            'fk-user_to_comment_complaint-comment_id',
            'user_to_comment_complaint',
            'comment_id',
            'comments',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user_to_comment_complaint-user_id',
            'user_to_comment_complaint'
        );

        $this->dropIndex(
            'idx-user_to_comment_complaint-user_id',
            'user_to_comment_complaint'
        );

        $this->dropForeignKey(
            'fk-user_to_comment_complaint-comment_id',
            'user_to_comment_complaint'
        );

        $this->dropIndex(
            'idx-user_to_comment_complaint-comment_id',
            'user_to_comment_complaint'
        );
        
        $this->dropTable('{{%user_to_comment_complaint}}');
    }
}
