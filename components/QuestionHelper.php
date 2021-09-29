<?php

namespace app\components;

use app\models\Comments;
use Yii;

/*
   Helper class for data processing
*/
class QuestionHelper
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
       Modifies a word based on a number
    */
    public static function numToWord($num, $words)
    {
        $num = $num % 100;
        if ($num > 19) {
            $num = $num % 10;
        }

        switch ($num) {
            case 1: 
                return($words[0]);
            
            case 2: case 3: case 4: 
                return($words[1]);
            
            default: 
                return($words[2]);
        }
    }

    /*
       Checking for the existence of a record in a linked table (UserToCommentLike, UserToQuestionSub) only
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
    public static function validateGetData($referef_url, $getData)
    {
        extract($getData, EXTR_OVERWRITE); // $question_id, $parent_id = null -> form data
        $refererExplodeArray = explode('/', $referef_url);

        // id of the question to which the comment is written
        $refererQuestionId = $refererExplodeArray[array_key_last($refererExplodeArray)];

        if ($refererQuestionId == $question_id) {
            if (isset($type) && $type != 1)
                return false;

            if (isset($parent_id)) {
                $commentExist = Comments::find()->where(['id' => $parent_id])->exists();

                if ($commentExist) 
                    return true;
            }

            return true;
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
}