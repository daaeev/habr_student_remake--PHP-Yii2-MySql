<?php

namespace app\models;

use app\components\questions\QuestionHelper;
use app\components\questions\QuestionHtmlGen;
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
            'content' => Yii::t('main', 'Поле для ввода комментария'),
        ];
    }

    public function createComment($question_id, $parent_id, $type)
    {
        $model = new Comments;
        $model->content = QuestionHtmlGen::contentProcessing($this->content);
        $model->author_id = Yii::$app->user->getId();
        $model->question_id = $question_id;
        $model->comment_kind = QuestionHelper::getKindOfComment($parent_id, $type);
        $model->parent_comment_id = $parent_id;
        
        $model->save();
    }
}