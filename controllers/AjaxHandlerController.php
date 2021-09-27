<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use app\models\UserToQuestionSub;

/*
   Class for handling ajax requests
*/
class AjaxHandlerController extends Controller
{
    public function actionLike($comment_id)
    {
        if (Yii::$app->request->isAjax) {
            // TODO...
        } else {
            throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
        }
    }

    public function actionSub($question_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = UserToQuestionSub::find()->where(['user_id' => Yii::$app->user->getId(), 'question_id' => $question_id])->one();

            if ($model) {
                $model->delete();
                
                return true;
            } else {
                $model = new UserToQuestionSub;
                $model->user_id = Yii::$app->user->getId();
                $model->question_id = $question_id;
                $model->save();

                return true;
            }
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }
}