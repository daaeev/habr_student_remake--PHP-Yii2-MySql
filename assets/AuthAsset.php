<?php

namespace app\assets;

use yii\web\AssetBundle;

class AuthAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'public/css/auth.min.css',
        '//cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css',
    ];
    public $js = [
        'public/js/ResolutionChanger.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
