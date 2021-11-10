<?php

namespace app\assets;

use yii\web\AssetBundle;

class FloatingPanelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'public/css/main.min.css',
    ];
    public $js = [
        'public/js/main.min.js',
    ];
    public $depends = [
        'app\assets\DependsAsset',
    ];
}
