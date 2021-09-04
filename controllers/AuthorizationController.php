<?php

namespace app\controllers;

use yii\web\Controller;

class AuthorizationController extends Controller
{
    public $layout = 'auth';

    public function actionLogin() {
        return $this->render('login');
    }

    public function actionRegistration() {
        return $this->render('registration');
    }
}
