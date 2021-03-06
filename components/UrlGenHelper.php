<?php

namespace app\components;

use yii\helpers\Url;

class UrlGenHelper
{
    /*
       Generate URLs for links to determine the type of questions to display
    */
    public static function categorySetting($category, $tag_id = null)
    {
        $page_url = (explode('/', \Yii::$app->request->pathInfo))[0];

        if ($page_url === 'my') {
            return '/my/' . $category;
        } elseif ($page_url === 't' && $tag_id !== null)
            return '/t/' . $tag_id . '/' . $category;

        return '/questions/' . $category;
    }

    public static function home()
    {
        return Url::home();
    }

    public static function simpleRoute($route)
    {
        return '/' . $route;
    }

    public static function login()
    {
        return '/login';
    }

    public static function registration()
    {
        return '/registration';
    }

    public static function logout()
    {
        return '/logout';
    }

    public static function adminPanel()
    {
        return '/admin/user';
    }

    public static function question($id)
    {
        return '/q/' . $id;
    }

    public static function user($id, $chapter = 'about')
    {
        return '/profile/' . $id . '/' . $chapter;
    }

    public static function tag($id)
    {
        return '/t/' . $id . '/interesting';
    }

    public static function userQuestions($user_id)
    {
        return '/profile/' . $user_id . '/questions';
    }

    public static function userAnswers($user_id)
    {
        return '/profile/' . $user_id . '/answers';
    }

    public static function forgotPass()
    {
        return '/forgot';
    }
}