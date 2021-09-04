<?php

namespace app\assets;

use yii\web\AssetBundle;

class PublicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'public/css/main.min.css',
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
