<?php

namespace app\controllers;

use app\components\QuestionHelper;
use app\models\Comments;
use app\components\QuestionHtmlGen;
use Yii;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use app\models\UserToQuestionSub;
use app\models\UserToCommentLike;
use yii\base\InvalidValueException;
use app\filters\NeededForAllVariables;

/*
   Class for handling ajax requests
*/
class HandlerController extends Controller
{
    public function behaviors()
    {
        return [
            NeededForAllVariables::class,
        ];
    }

    public function actionLike($comment_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = UserToCommentLike::find()->where(['user_id' => Yii::$app->view->params['user']->id, 'comment_id' => $comment_id])->one();

            if ($model) 
                return $model->delete();
            else {
                $model = new UserToCommentLike;

                return $model->createRelation($comment_id);
            }
        }
        
        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionSub($question_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = UserToQuestionSub::find()->where(['user_id' => Yii::$app->view->params['user']->id, 'question_id' => $question_id])->one();

            if ($model) 
                return $model->delete();
            else {
                $model = new UserToQuestionSub;

                return $model->createRelation($question_id);
            }
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionDeleteComment($comment_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = Comments::findOne($comment_id);
            if ($model->isAuthor(Yii::$app->view->params['user'])) 
                return $model->delete();
            else 
                throw new InvalidValueException('На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionCommentEdit($content, $comment_id, $old_content)
    {
        if (Yii::$app->request->isAjax) {
            if ($comment = QuestionHelper::validateGetData([
                    'comment_id' => $comment_id,
                    'old_content' => $old_content,
                ], 'edit')
            ) {
                $comment->content = QuestionHtmlGen::contentProcessing($content);

                return $comment->save(false);
            } else 
                throw new InvalidValueException('На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionComplain($comment_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = Comments::findOne($comment_id);
            if ($model) 
                return QuestionHelper::complain($model);
            else 
                throw new InvalidValueException('На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }
}