<?php

namespace app\components;

use yii\helpers\Url;

class UrlGenHelper {
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
}