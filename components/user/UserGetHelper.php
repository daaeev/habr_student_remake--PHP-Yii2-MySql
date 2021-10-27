<?php

namespace app\components\user;

use app\models\User;
use app\models\Comments;
use app\components\lib\GetHelperClass;

class UserGetHelper extends GetHelperClass
{
    public static function userById($id)
    {
        return User::find()
            ->where(['id' => $id])
            ->one();
    }

    public static function getAnswers($user_id)
    {
        $query = Comments::find()
            ->cache(100)
            ->where(['author_id' => $user_id, 'comment_kind' => 2])
            ->joinWith('userToCommentLikes')
            ->with('question')
            ->orderBy('id DESC');

        $data = self::getPaginationData($query);

        return $data;
    }
}