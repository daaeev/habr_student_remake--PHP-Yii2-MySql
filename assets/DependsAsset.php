<?php

namespace app\assets;

use yii\web\AssetBundle;

class DependsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'public/css/fonts.css',
        '//cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css',
    ];
    public $js = [
        'public/js/ResolutionChanger.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
