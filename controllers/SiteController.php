<?php

namespace app\controllers;

use Yii;
use app\models\AskForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\components\UrlGenHelper;
use app\components\QuestionsGetHelper;

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
            [
                'class' => 'app\filters\SidebarQuestions',
            ],
        ];
    }
    
    public function actionIndex($category = 'interesting')
    {
        $questions_data = QuestionsGetHelper::$category();

        return $this->render('index', [
            'questions' => $questions_data['questions'],
            'pagination' => $questions_data['pagination'],
        ]);
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
        $model = new AskForm;

        if ($model->load(Yii::$app->request->post(), 'AskForm') && $model->createQuestion()) {
            return $this->redirect(UrlGenHelper::home());
        }

        return $this->render('ask_question', compact('model'));
    }

    public function actionError()
    {
        $this->layout = 'error';
        return $this->render('error');
    }
}
