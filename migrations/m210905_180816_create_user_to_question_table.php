<?php

use yii\db\Migration;

class m210905_180816_create_user_to_question_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user_to_question_sub}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'question_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-user_to_question_sub-user_id',
            'user_to_question_sub',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_to_question_sub-user_id',
            'user_to_question_sub',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_to_question_sub-question_id',
            'user_to_question_sub',
            'question_id'
        );

        $this->addForeignKey(
            'fk-user_to_question_sub-question_id',
            'user_to_question_sub',
            'question_id',
            'question',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user_to_question_sub-user_id',
            'user_to_question_sub'
        );

        $this->dropIndex(
            'idx-user_to_question_sub-user_id',
            'user_to_question_sub'
        );

        $this->dropForeignKey(
            'fk-user_to_question_sub-question_id',
            'user_to_question_sub'
        );

        $this->dropIndex(
            'idx-user_to_question_sub-question_id',
            'user_to_question_sub'
        );

        $this->dropTable('{{%user_to_question_sub}}');
    }
}
