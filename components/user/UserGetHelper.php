<?php

namespace app\components\user;

use app\models\User;
use app\models\Comments;
use app\components\lib\GetHelperClass;
use yii\web\NotFoundHttpException;

class UserGetHelper extends GetHelperClass
{
    public static function userById($id)
    {
        $model = User::find()
            ->where(['id' => $id])
            ->with('questions', 'comments')
            ->one();
        
        /*
           Ban check
        */
        if ($model) {
            if ($model->status == 3) {
                throw new NotFoundHttpException('Пользователь забанен: ' . $model->ban_reason);
            }

            return $model;
        }

        throw new NotFoundHttpException('Пользователь не найден');
    }

    public static function getAnswers($user_id)
    {
        $query = Comments::find()
            ->cache(100)
            ->where(['author_id' => $user_id, 'comment_kind' => [2, 4]])
            ->with('question', 'userToCommentLikes')
            ->orderBy('id DESC');

        $data = self::getPaginationData($query);

        return $data;
    }
}