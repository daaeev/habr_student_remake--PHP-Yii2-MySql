<?php

namespace app\modules\admin\controllers;

use app\models\Question;
use app\models\QuestionSearch;
use app\models\TagImage;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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

    public function actionCreateTags($id, $tags)
    {
        $tags_models_array = TagImage::generateModels($tags);

        if (Yii::$app->request->post('TagImage')) {
            /*
               If the form was submitted, then assign its own image to each model
            */
            foreach ($tags_models_array as $index => $tag) {
                $tag->image = UploadedFile::getInstance($tag, "image[$index]");
            }

            /*
               If the models are validated successfully, create tags
            */
            if (Model::validateMultiple($tags_models_array)) {
                foreach ($tags_models_array as $tag) {
                    $tag->createTag($id);
                }

                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('createTags', [
            'models_array' => $tags_models_array,
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
