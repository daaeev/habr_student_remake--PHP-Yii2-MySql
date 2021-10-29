<?php

namespace app\controllers;

use app\components\questions\QuestionHelper;
use app\models\Comments;
use app\components\questions\QuestionHtmlGen;
use Yii;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use app\models\UserToQuestionSub;
use app\models\UserToCommentLike;
use app\models\UserToTagSub;
use yii\web\HttpException;
use app\filters\NeededForAllVariables;
use app\models\Question;
use app\models\Tags;
use app\components\comments\CommentHelper;

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
            if (Comments::find()->where(['id' => $comment_id])->exists()) {
                $model = UserToCommentLike::find()->where(['user_id' => Yii::$app->view->params['user']->id, 'comment_id' => $comment_id])->one();

                if ($model) 
                    return $model->delete();
                else {
                    $model = new UserToCommentLike;

                    return $model->createRelation($comment_id);
                }
            } else 
                throw new HttpException('На обработку получены некорректные данные');
        }
        
        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionSubQuestion($question_id)
    {
        if (Yii::$app->request->isAjax) {
            if (Question::find()->where(['id' => $question_id])->exists()) {
                $model = UserToQuestionSub::find()->where(['user_id' => Yii::$app->view->params['user']->id, 'question_id' => $question_id])->one();

                if ($model) 
                    return $model->delete();
                else {
                    $model = new UserToQuestionSub;

                    return $model->createRelation($question_id);
                }
            } else 
                throw new HttpException('На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionSubTag($tag_id)
    {
        if (Yii::$app->request->isAjax) {
            if (Tags::find()->where(['id' => $tag_id])->exists()) {
                $model = UserToTagSub::find()->where(['user_id' => Yii::$app->view->params['user']->id, 'tag_id' => $tag_id])->one();
                
                if ($model) 
                    return $model->delete();
                else {
                    $model = new UserToTagSub;

                    return $model->createRelation($tag_id);
                }
            } else 
                throw new HttpException('На обработку получены некорректные данные');
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
                throw new HttpException('На обработку получены некорректные данные');
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
                throw new HttpException('На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionComplain($comment_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = Comments::findOne($comment_id);
            if ($model) 
                return CommentHelper::complain($model);
            else 
                throw new HttpException('На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionApproveAnswer($comment_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = Comments::findOne($comment_id);
            if ($model) 
                return CommentHelper::approveAnswer($model);
            else 
                throw new HttpException('На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }
}