<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%questions}}`.
 */
class m210905_164544_create_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' => $this->text(),
            'content' => $this->string(),
            'author_id' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(0),
            'views' => $this->integer()->defaultValue(0),
            'pub_date' => $this->integer(),
            'difficulty' => $this->string(),
            'ban_reason' => $this->string(),
        ]);

        $this->createIndex(
            'idx-question-author_id',
            'question',
            'author_id'
        );

        $this->addForeignKey(
            'fk-question-author_id',
            'question',
            'author_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-question-author_id',
            'question'
        );

        $this->dropIndex(
            'idx-question-author_id',
            'question'
        );

        $this->dropTable('{{%question}}');
    }
}
