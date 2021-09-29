<?php

namespace app\controllers;

use app\components\QuestionHelper;
use app\models\CommentsPosting;
use Yii;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use app\models\UserToQuestionSub;
use app\models\UserToCommentLike;

/*
   Class for handling ajax requests
*/
class HandlerController extends Controller
{
    public function actionLike($comment_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = UserToCommentLike::find()->where(['user_id' => Yii::$app->user->getId(), 'comment_id' => $comment_id])->one();

            if ($model) {
                return $model->delete();
            } else {
                $model = new UserToCommentLike;

                return $model->createRelation($comment_id);
            }
        }
        
        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionSub($question_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = UserToQuestionSub::find()->where(['user_id' => Yii::$app->user->getId(), 'question_id' => $question_id])->one();

            if ($model) {
                return $model->delete();
            } else {
                $model = new UserToQuestionSub;

                return $model->createRelation($question_id);
            }
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionComment($question_id, $parent_id = null, $type = null)
    {
        if (Yii::$app->request->isPost) {
            if (QuestionHelper::validateGetData($_SERVER['HTTP_REFERER'], [
                    'question_id' => $question_id,
                    'parent_id' => $parent_id,
                    'type' => $type,
                ])
            ) {
                $model = new CommentsPosting;
                
                if ($model->load(Yii::$app->request->post(), 'CommentsPosting')) {
                    $model->createComment($question_id, $parent_id, $type);
                }
            }
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}