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
       Divides comments into 4 groups
    */
    public static function splitComments($comments)
    {
        $mainComments = [];
        $answers = [];
        $approveAnswers = [];
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
                case 4:
                    $approveAnswers[] = $comment;
                    break;
            }
        }

        return compact('mainComments', 'answers', 'commentsToAnswers', 'approveAnswers');
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

    public static function getChildrenComments($answersGroup, $childComments)
    {
        $answers = [];
        foreach ($answersGroup as $group)
            foreach ($group as $answer)
                if ($answer->comment_kind == 2 || $answer->comment_kind == 4)
                    $answers[] = $answer;

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
        foreach ($answers as $answerGroup) 
            foreach ($answerGroup as $answer)
                if ($answer->isAuthor($user))
                    return true;
    }
}