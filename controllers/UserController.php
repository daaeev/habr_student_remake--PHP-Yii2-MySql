<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\VerbFilter;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        return [    
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                    'options' => ['options'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['delete'], $actions['update'], $actions['create']);

        return $actions;
    }

    public function fields()
    {
        ['id', 'name', 'description', 'contribution'];
    }
}