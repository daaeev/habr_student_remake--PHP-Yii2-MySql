<?php

namespace app\controllers;

use Yii;
use app\components\UrlGenHelper;
use yii\web\Controller;
use app\models\UserRegistration;
use app\models\UserLogin;

class AuthorizationController extends Controller
{
    public $layout = 'auth';

    public function actionLogin() {
        $model = new UserLogin;

        if ($model->load(Yii::$app->request->post(), 'UserLogin') && $model->login()) {
            return $this->redirect(UrlGenHelper::home());
        }

        return $this->render('login', compact('model'));
    }

    public function actionRegistration() {
        $model = new UserRegistration;

        if ($model->load(Yii::$app->request->post(), 'UserRegistration') && $model->register()) {
            return $this->redirect(UrlGenHelper::home());
        }

        return $this->render('registration', compact('model'));
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(UrlGenHelper::home());
    }
}
