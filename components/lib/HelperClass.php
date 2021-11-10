<?php

namespace app\components\lib;

use Yii;

class HelperClass 
{
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
}