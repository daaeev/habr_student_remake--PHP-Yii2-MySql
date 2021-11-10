<?php

namespace app\components\user;

use app\components\user\UserHelper;
use app\components\lib\HtmlGenHelper;
use Yii;
use yii\helpers\Html;

class UserHtmlGen extends HtmlGenHelper
{
    public static function description($text)
    {
        return Html::encode($text);
    }

    public static function questionsCount($user)
    {
        $count = count($user->questions);

        return '<p>' . $count . '</p>' . Yii::t('main', UserHelper::numToWord($count, ['вопрос', 'вопроса', 'вопросов']));
    }

    public static function answersCount($user)
    {
        $count = UserHelper::answersCount($user);

        return '<p>' . $count . '</p>' . Yii::t('main', UserHelper::numToWord($count, ['ответ', 'ответа', 'ответов']));
    }

    public static function contribution($user)
    {
        return '<p>' . $user->contribution . '</p>' . Yii::t('main', 'вклад');
    }
}