<?php

namespace app\models;

class Comments extends \yii\db\ActiveRecord
{
    use \app\components\behaviors\AuthorCheckBehavior;
    public $childComments = [];

    public static function tableName()
    {
        return 'comments';
    }

    public function rules()
    {
        return [
            [['content'], 'string'],
            [['author_id', 'question_id', 'comment_kind', 'parent_comment_id', 'complaints'], 'integer'],
            [['pub_date'], 'default', 'value' => time()],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::class, 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'author_id' => 'Author ID',
            'question_id' => 'Question ID',
            'pub_date' => 'Pub Date',
            'comment_kind' => 'Comment Kind',
            'parent_comment_id' => 'Parent Comment ID',
            'complaints' => 'Complaints'
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getQuestion()
    {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }

    public function getUserToCommentLikes()
    {
        return $this->hasMany(UserToCommentLike::class, ['comment_id' => 'id']);
    }

    public function getUserToCommentComplaints()
    {
        return $this->hasMany(UserToCommentComplaint::class, ['comment_id' => 'id']);
    }
}
