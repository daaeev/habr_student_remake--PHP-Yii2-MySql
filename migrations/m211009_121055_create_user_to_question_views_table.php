<?php

use yii\db\Migration;

class m211009_121055_create_user_to_question_views_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%user_to_question_views}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'question_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-user_to_question_views-user_id',
            'user_to_question_views',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_to_question_views-user_id',
            'user_to_question_views',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_to_question_views-question_id',
            'user_to_question_views',
            'question_id'
        );

        $this->addForeignKey(
            'fk-user_to_question_views-question_id',
            'user_to_question_views',
            'question_id',
            'question',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user_to_question_views-user_id',
            'user_to_question_views'
        );

        $this->dropIndex(
            'idx-user_to_question_views-user_id',
            'user_to_question_views'
        );

        $this->dropForeignKey(
            'fk-user_to_question_views-question_id',
            'user_to_question_views'
        );

        $this->dropIndex(
            'idx-user_to_question_views-question_id',
            'user_to_question_views'
        );
        
        $this->dropTable('{{%user_to_question_views}}');
    }
}
