<?php

namespace app\components\user;

use app\components\lib\HtmlGenHelper;
use yii\helpers\Html;

class UserHtmlGen extends HtmlGenHelper
{
    public static function description($text)
    {
        if ($text)
            return Html::encode($text);

        return 'Пользователь ещё не оставил описание!';
    }
}