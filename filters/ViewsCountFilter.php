<?php

namespace app\filters;

use Yii;
use yii\base\ActionFilter;
use app\models\UserToQuestionViews;
use app\components\QuestionHelper;
use app\models\Question;

class ViewsCountFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        $question_id = Yii::$app->request->get('id');
        if (
            !Yii::$app->user->isGuest
            && !QuestionHelper::existCheck(UserToQuestionViews::class, ['question_id' => $question_id])
        ) {
            $model = new UserToQuestionViews;
            $model->user_id = Yii::$app->user->getId();
            $model->question_id = $question_id;
            $model->save();

            $question = Question::findOne($question_id);
            $question->updateCounters(['views' => 1]);
        }

        return parent::beforeAction($action);
    }
}