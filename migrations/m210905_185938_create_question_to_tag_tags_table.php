<?php

use yii\db\Migration;

class m210905_185938_create_question_to_tag_tags_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%question_to_tag_tags}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-question_to_tag_tags-question_id',
            'question_to_tag_tags',
            'question_id'
        );

        $this->addForeignKey(
            'fk-question_to_tag_tags-question_id',
            'question_to_tag_tags',
            'question_id',
            'question',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-question_to_tag_tags-tag_id',
            'question_to_tag_tags',
            'tag_id'
        );

        $this->addForeignKey(
            'fk-question_to_tag_tags-tag_id',
            'question_to_tag_tags',
            'tag_id',
            'tags',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-question_to_tag_tags-question_id',
            'question_to_tag_tags'
        );

        $this->dropIndex(
            'idx-question_to_tag_tags-question_id',
            'question_to_tag_tags'
        );

        $this->dropForeignKey(
            'fk-question_to_tag_tags-tag_id',
            'question_to_tag_tags'
        );

        $this->dropIndex(
            'idx-question_to_tag_tags-tag_id',
            'question_to_tag_tags'
        );

        $this->dropTable('{{%question_to_tag_tags}}');
    }
}
