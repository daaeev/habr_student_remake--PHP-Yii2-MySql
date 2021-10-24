<?php

namespace app\components\questions;

use app\models\Comments;
use app\models\UserToCommentComplaint;
use Yii;
use yii\helpers\Html;
use app\components\lib\HelperClass;

/*
   Helper class for data processing
*/
class QuestionHelper extends HelperClass
{
    /*
       Divides comments into 3 groups
    */
    public static function splitComments($comments)
    {
        $mainComments = [];
        $answers = [];
        $commentsToAnswers = [];

        foreach ($comments as $comment) {
            switch ($comment->comment_kind) {
                case 1:
                    $mainComments[] = $comment;
                    break;
                case 2:
                    $answers[] = $comment;
                    break;
                case 3:
                    $commentsToAnswers[] = $comment;
                    break;
            }
        }

        return compact('mainComments', 'answers', 'commentsToAnswers');
    }

    /*
       Checking for the existence of a record in a linked table (UserToCommentLike, UserToQuestionSub, UserToQuestionViews, UserToQuestionComplain)
    */
    public static function existCheck($linkName, $data)
    {
        return $linkName::find()
            ->where([
                array_key_first($data) => $data[array_key_first($data)], 
                'user_id' => Yii::$app->user->getId()
            ])
            ->exists();
    }

    /*
       Checking the authenticity of data from the comment form
    */
    public static function validateGetData($getData, $type)
    {   
        if ($type == 'create') {
            extract($getData, EXTR_OVERWRITE); // $question_id, $parent_id = null, $referef_url -- get-parametrs data
            $refererExplodeArray = explode('/', $referer_url);

            // id of the question to which the comment was written
            $refererQuestionId = $refererExplodeArray[array_key_last($refererExplodeArray)];

            if ($refererQuestionId == $question_id) {
                if (isset($type) && $type != 1)
                    return false;

                if (isset($parent_id)) {
                    $commentExist = Comments::find()->where(['id' => $parent_id])->exists();

                    if ($commentExist) 
                        return true;
                    else 
                        return false;
                }

                return true;
            }
        } else if ($type == 'edit') {
            extract($getData, EXTR_OVERWRITE); // $comment_id, $old_content -- get-parametrs data
            
            $comment = Comments::findOne($comment_id);
            if (
                $comment->isAuthor(Yii::$app->view->params['user'])
                && html::decode($comment->content) == html::decode($old_content)
            ) {
                return $comment;
            }
        }

        return false;
    }

    public static function getKindOfComment($parent, $type) : int
    {
        if (isset($parent))
            return 3;
        if (isset($type))
            return 1;
        else
            return 2;
    }

    public static function getChildrenComments($answers, $childComments)
    {
        foreach ($answers as $answer) {
            foreach ($childComments as $comment) {
                if ($comment->parent_comment_id == $answer->id) {
                    $answer->childComments[] = $comment;
                }
            }
        }
    }

    public static function checkUserHaveAnswer($user, $answers)
    {
        foreach ($answers as $answer) {
            if ($answer->isAuthor($user))
                return true;
        }
    }

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
}