<?php

namespace app\assets;

use yii\web\AssetBundle;

class WithoutPanelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'public/css/auth.min.css',
    ];
    public $js = [
        'public/js/auth.min.js',
    ];

    public $depends = [
        'app\assets\DependsAsset',
    ];
}
