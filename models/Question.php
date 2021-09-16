<?php

namespace app\models;

use Yii;

class Question extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'question';
    }

    public function rules()
    {
        return [
            [['content', 'tags'], 'string'],
            [['author_id', 'status', 'viewed'], 'integer'],
            [['pub_date'], 'default', 'value' => date('d.m.Y')],
            [['title'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'author_id' => 'Author',
            'status' => 'Status',
            'viewed' => 'Viewed',
            'pub_date' => 'Pub Date',
            'difficulty' => 'Difficulty',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['question_id' => 'id']);
    }

    /**
     * Gets query for [[QuestionToTagTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionToTagTags()
    {
        return $this->hasMany(QuestionToTagTags::class, ['question_id' => 'id']);
    }

    /**
     * Gets query for [[UserToQuestionSubs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserToQuestionSubs()
    {
        return $this->hasMany(UserToQuestionSub::class, ['question_id' => 'id']);
    }
}
