<?php

use yii\db\Migration;

class m210905_181439_create_comments_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'content' => $this->text(),
            'author_id' => $this->integer(),
            'question_id' => $this->integer(),
            'pub_date' => $this->date(),
            'comment_kind' => $this->smallInteger(),
            'parent_comment_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-comments-author_id',
            'comments',
            'author_id'
        );

        $this->addForeignKey(
            'fk-comments-author_id',
            'comments',
            'author_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-comments-question_id',
            'comments',
            'question_id'
        );

        $this->addForeignKey(
            'fk-comments-question_id',
            'comments',
            'question_id',
            'question',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    { 
        $this->dropForeignKey(
            'fk-comments-author_id',
            'comments'
        );
        $this->dropIndex(
            'idx-comments-author_id',
            'comments'
        );

        $this->dropForeignKey(
            'fk-comments-question_id',
            'comments'
        );

        $this->dropIndex(
            'idx-comments-question_id',
            'comments'
        );

        $this->dropTable('{{%comments}}');
    }
}
