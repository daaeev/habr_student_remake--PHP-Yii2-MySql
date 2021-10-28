<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Question;
use app\models\QuestionSearch;
use app\models\TagModel;
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

    /*
      $id -> question id; 
    */
    public function actionCreateTags($id, $tags)
    {
        $tags_models_array = TagModel::generateModels($tags, $id);

        if (Yii::$app->request->post('TagModel')) {
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

    public function actionBanPage($id)
    {
        return $this->render('banPage', compact('id'));
    }

    public function actionBan()
    {
        if ($attributes = Yii::$app->request->post()) 
            $this->setStatus($this->findModel($attributes['question_id']), 2, $attributes['ban_reason']);
    }

    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена');
    }

    private function setStatus(Question $question, int $status, $ban_reason = '')
    {
        $question->status = $status;
        $question->ban_reason = $ban_reason;
        $question->save(false);

        $this->redirect(['view', 'id' => $question->id]);
    }
}
