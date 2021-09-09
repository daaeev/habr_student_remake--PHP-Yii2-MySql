<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SiteController extends Controller
{
    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create-question'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create-question'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMy()
    {
        return $this->render('index');
    }

    public function actionSingle()
    {
        return $this->render('single');
    }

    public function actionTags()
    {
        return $this->render('tags');
    }

    public function actionTag()
    {
        return $this->render('index');
    }

    public function actionCreateQuestion()
    {
        return $this->render('ask_question');
    }

    public function actionError()
    {
        $this->layout = 'error';
        return $this->render('error');
    }
}
