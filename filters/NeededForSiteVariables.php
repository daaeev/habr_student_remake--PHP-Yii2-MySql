<?php

namespace app\filters;

use yii\base\ActionFilter;
use app\components\questions\QuestionsGetHelper;
use Yii;

class NeededForSiteVariables extends NeededForAllVariables
{
    public function beforeAction($action)
    {
        Yii::$app->view->params['sidebar_questions'] = QuestionsGetHelper::sidebarQuestions();

        return parent::beforeAction($action);
    }
}