<?php

namespace app\filters;

use yii\base\ActionFilter;
use app\components\QuestionsGetHelper;
use Yii;

class NeededVariables extends ActionFilter
{
    public function beforeAction($action)
    {
        Yii::$app->view->params['sidebar_questions'] = QuestionsGetHelper::sidebarQuestions();
        Yii::$app->view->params['user'] = Yii::$app->user->getIdentity();

        return parent::beforeAction($action);
    }
}