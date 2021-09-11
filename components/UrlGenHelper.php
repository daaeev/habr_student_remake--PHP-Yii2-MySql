<?php

namespace app\components;

use yii\helpers\Url;

class UrlGenHelper
{
    /*
       Generate URLs for links to determine the type of questions to display
    */
    public static function categorySetting($category)
    {
        if((explode('/', \Yii::$app->request->pathInfo))[0] === 'my') {
            return '/my/' . $category;
        }
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
}