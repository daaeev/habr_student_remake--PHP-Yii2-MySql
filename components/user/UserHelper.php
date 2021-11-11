<?php

namespace app\components\user;

use app\components\lib\HelperClass;

class UserHelper extends HelperClass
{
    public static function answersCount($user)
    {
        $count = 0;

        foreach ($user->comments as $comment)
            if ($comment->comment_kind == 2 || $comment->comment_kind == 4)
                $count++;

        return $count;
    }

    public static function translateTime($user_timestamp)
    {
        $time_to_can_ask = $user_timestamp - time();
        
        return date('H часов i минут s секунд', $time_to_can_ask);
    }

    public static function generateTime($user)
    {
        $contribution = $user->contribution;
        $time_to_can_ask = time();

        if ($user->status != 0 && $user->status != 3)
            return $time_to_can_ask;

        if ($contribution >= 0 && $contribution < 3)
            $time_to_can_ask += (3600 * 24);
        elseif ($contribution >= 3 && $contribution < 7)
            $time_to_can_ask += (3600 * 12);
        elseif ($contribution >= 7 && $contribution < 10)
            $time_to_can_ask += (3600 * 5);
        else
            $time_to_can_ask += (3600);
        
        return $time_to_can_ask;
    }
}