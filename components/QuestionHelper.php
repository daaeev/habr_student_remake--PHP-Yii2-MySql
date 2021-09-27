<?php

namespace app\components;

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
       Checking for the existence of a record in a linked table
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
}