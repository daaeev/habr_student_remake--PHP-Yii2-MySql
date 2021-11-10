<?php

namespace app\models;

use Yii;

class Question extends \yii\db\ActiveRecord
{
    use \app\components\behaviors\AuthorCheckBehavior;
    
    public static function tableName()
    {
        return 'question';
    }

    public function rules()
    {
        return [
            [['content', 'tags'], 'string'],
            [['author_id', 'status', 'views'], 'integer'],
            [['pub_date'], 'default', 'value' => time()],
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
            'pub_date' => 'Pub Date',
            'difficulty' => 'Difficulty',
            'ban_reason' => 'Ban Reason'
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

    public function getUserToQuestionViews()
    {
        return $this->hasMany(UserToQuestionViews::class, ['question_id' => 'id']);
    }
}
