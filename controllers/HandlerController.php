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
use app\models\User;

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
                throw new HttpException(400, 'На обработку получены некорректные данные');
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
                throw new HttpException(400, 'На обработку получены некорректные данные');
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
                throw new HttpException(400, 'На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionDeleteComment($object_type, $object_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = $object_type::findOne($object_id);
            if ($model->isAuthor(Yii::$app->view->params['user'])) 
                return $model->delete();
            else 
                throw new HttpException(400, 'На обработку получены некорректные данные');
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
                throw new HttpException(400, 'На обработку получены некорректные данные');
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
                throw new HttpException(400, 'На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionApproveAnswer($comment_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = Comments::findOne($comment_id);
            if ($model) {
                $user = User::findOne($model->author_id);
                $user->updateContribution(1);

                return CommentHelper::approveAnswer($model);
            }
            else 
                throw new HttpException(400, 'На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionSetDescription($description, $author_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = User::findOne($author_id);
            if ($model)
                return $model->setDescription($description);
            else 
                throw new HttpException(400, 'На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionForgotPassword($username, $email)
    {
        if (Yii::$app->request->isAjax) {
            $model = User::find()->where(['name' => $username, 'email' => $email])->one();

            if ($model) {
                $user_new_pass = $model->changePass();

                Yii::$app->mailer->compose()
                    ->setFrom('') // Specify gmail
                    ->setTo($email)
                    ->setSubject(Yii::t('main', 'Сброс пароля'))
                    ->setTextBody(Yii::t('main', 'Ваш новый пароль - ') . $user_new_pass)
                    ->send();
            }

            return true;
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }

    public function actionChangePassword($old_pass, $new_pass)
    {
        if (Yii::$app->request->isAjax) {
            $user = Yii::$app->view->params['user'];
            
            if (Yii::$app->getSecurity()->validatePassword($old_pass, $user->password)) {
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($new_pass);
                $user->save(false);

                return true;
            }

            throw new HttpException(400, 'На обработку получены некорректные данные');
        }

        throw new MethodNotAllowedHttpException('Ошибка! Данная страница не подерживает такой вид запроса');
    }
}