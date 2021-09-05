<?php

use yii\db\Migration;

class m210905_185220_create_user_to_comment_like_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user_to_comment_like}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'comment_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-user_to_comment_like-user_id',
            'user_to_comment_like',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_to_comment_like-user_id',
            'user_to_comment_like',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        
        $this->createIndex(
            'idx-user_to_comment_like-comment_id',
            'user_to_comment_like',
            'comment_id'
        );

        $this->addForeignKey(
            'fk-user_to_comment_like-comment_id',
            'user_to_comment_like',
            'comment_id',
            'comments',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user_to_comment_like-user_id',
            'user_to_comment_like'
        );

        $this->dropIndex(
            'idx-user_to_comment_like-user_id',
            'user_to_comment_like'
        );

        $this->dropForeignKey(
            'fk-user_to_comment_like-comment_id',
            'user_to_comment_like'
        );
        
        $this->dropIndex(
            'idx-user_to_comment_like-comment_id',
            'user_to_comment_like'
        );

        $this->dropTable('{{%user_to_comment_like}}');
    }
}
