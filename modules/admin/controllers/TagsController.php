<?php

namespace app\modules\admin\controllers;

use app\models\Tags;
use app\models\TagsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TagsController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new TagsSearch();
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

    public function actionDelete($id)
    {
        $tag = $this->findModel($id);

        if ($tag->tag_image != 'tag.jpg') {
            unlink(substr($tag->getImage(), 1));
        }

        $tag->delete();
        return $this->redirect('index');
    }

    protected function findModel($id)
    {
        if (($model = Tags::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
