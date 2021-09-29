<?php

namespace app\models;

use app\components\QuestionHelper;
use Yii;
use yii\base\Model;

class CommentsPosting extends Model
{
    public $content;

    public function rules()
    {
        return [
            ['content', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'content' => 'Поле для ввода комментария',
        ];
    }

    public function createComment($question_id, $parent_id, $type)
    {
        $model = new Comments;
        $model->content = $this->content;
        $model->author_id = Yii::$app->user->getId();
        $model->question_id = $question_id;
        $model->comment_kind = QuestionHelper::getKindOfComment($parent_id, $type);
        $model->parent_comment_id = $parent_id;
        
        $model->save();
    }
}