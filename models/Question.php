<?php

namespace app\models;

use Yii;

class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['author_id', 'status', 'viewed'], 'integer'],
            [['pub_date'], 'safe'],
            [['title', 'difficulty'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'author_id' => 'Author ID',
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
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['question_id' => 'id']);
    }

    /**
     * Gets query for [[QuestionToTagTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionToTagTags()
    {
        return $this->hasMany(QuestionToTagTags::className(), ['question_id' => 'id']);
    }

    /**
     * Gets query for [[UserToQuestionSubs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserToQuestionSubs()
    {
        return $this->hasMany(UserToQuestionSub::className(), ['question_id' => 'id']);
    }
}
