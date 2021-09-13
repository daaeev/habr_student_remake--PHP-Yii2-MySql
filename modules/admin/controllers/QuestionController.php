<?php

namespace app\modules\admin\controllers;

use app\models\Question;
use app\models\QuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class QuestionController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionApprove($id)
    {
        $this->setStatus($this->findModel($id), 1);
    }

    public function actionBan($id)
    {
        $this->setStatus($this->findModel($id), 2);
    }

    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function setStatus(Question $question, int $status)
    {
        $question->status = $status;
        $question->save(false);

        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
