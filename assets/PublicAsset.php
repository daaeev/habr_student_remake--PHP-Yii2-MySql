<?php

namespace app\assets;

use yii\web\AssetBundle;

class PublicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'public/css/index.css',
        'public/css/single.css',
        'public/css/ask.css',
        'public/css/aside.css',
        'public/css/fonts.css',
        'public/css/tags.css',
        '//cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css',
    ];
    public $js = [
        'public/js/ResolutionChanger.js',
        'public/js/FloatingPanel.js',
        'public/js/SettingsLinksCustomize.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
