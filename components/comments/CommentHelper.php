<?php

namespace app\components\comments;

use app\components\lib\HelperClass;
use app\models\UserToCommentComplaint;
use Yii;

class CommentHelper extends HelperClass
{
    public static function complain($comment)
    {
        if (
            !self::existCheck(UserToCommentComplaint::class, ['comment_id' => $comment->id])
            && !$comment->isAuthor(Yii::$app->view->params['user'])
        ) {
            $comment->updateCounters(['complaints' => 1]);

            $linkModel = new UserToCommentComplaint;
            $linkModel->user_id = Yii::$app->view->params['user']->id;
            $linkModel->comment_id = $comment->id;

            return $linkModel->save();
        }
    }

    public static function approveAnswer($comment)
    {
        if ($comment->comment_kind == 2) {
            $comment->comment_kind = 4;
            $comment->save(false);
        }
    }

    public static function answersCount($comment)
    {
        if (count($comment['answers']) > 0 || count($comment['approveAnswers']) > 0)
            return true;
    }
}