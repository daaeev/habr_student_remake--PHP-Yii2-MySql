<?php

namespace app\components;

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
}