<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public $layout = 'main';
    
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionMy() {
        return $this->render('index');
    }

    public function actionSingle() {
        return $this->render('single');
    }

    public function actionTags() {
        return $this->render('tags');
    }

    public function actionCreateQuestion() {
        return $this->render('ask_question');
    }
}
