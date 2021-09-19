<?php

namespace app\filters;

use yii\base\ActionFilter;
use app\components\QuestionsGetHelper;

class SidebarQuestions extends ActionFilter
{
    public function beforeAction($action)
    {
        $sidebar_questions = QuestionsGetHelper::sidebarQuestions();
        \Yii::$app->view->params['sidebar_questions'] = $sidebar_questions;

        return parent::beforeAction($action);
    }
}