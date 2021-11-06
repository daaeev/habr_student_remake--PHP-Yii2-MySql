<?php

namespace app\controllers;

use Yii;
use app\components\UrlGenHelper;
use yii\web\Controller;
use app\models\UserRegistration;
use app\models\UserLogin;
use app\models\User;
use app\models\Auth;
use app\models\ChangePassword;
use yii\filters\AccessControl;

class AuthorizationController extends Controller
{
    public $layout = 'auth';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'registration', 'forgot', 'on-auth-success'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'change-password'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionLogin() {
        $model = new UserLogin;

        if ($model->load(Yii::$app->request->post(), 'UserLogin') && $model->login()) {
            return $this->redirect(UrlGenHelper::home());
        }

        return $this->render('login', compact('model'));
    }

    public function actionForgot()
    {
        return $this->render('forgot');
    }

    /*
       Регистрация через внешний сервис
    */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();
        
        if (Yii::$app->user->isGuest) {
            if ($auth) { // авторизация
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else { // регистрация
                if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "Пользователь с такой электронной почтой как в {client} уже существует, но с ним не связан. Для начала войдите на сайт использую электронную почту, для того, что бы связать её.", ['client' => $client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'name' => $attributes['login'],
                        'email' => $attributes['email'],
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$attributes['id'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                        } else {
                            print_r($auth->getErrors());
                        }
                    } else {
                        print_r($user->getErrors());
                    }
                }
            }
        } else { // Пользователь уже зарегистрирован
            if (!$auth) { // добавляем внешний сервис аутентификации
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }

    public function actionRegistration() {
        $model = new UserRegistration;

        if ($model->load(Yii::$app->request->post(), 'UserRegistration') && $model->register()) {
            return $this->redirect(UrlGenHelper::home());
        }

        return $this->render('registration', compact('model'));
    }

    public function actionChangePassword()
    {
        $model = new ChangePassword;

        return $this->render('change', compact('model'));
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(UrlGenHelper::home());
    }
}
