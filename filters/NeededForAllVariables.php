<?php

namespace app\filters;

use yii\base\ActionFilter;
use Yii;

class NeededForAllVariables extends ActionFilter
{
    public function beforeAction($action)
    {
        Yii::$app->view->params['user'] = Yii::$app->user->getIdentity();

        return parent::beforeAction($action);
    }
}