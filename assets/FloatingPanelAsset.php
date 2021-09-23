<?php

namespace app\assets;

use yii\web\AssetBundle;

class FloatingPanelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'public/css/index.css',
        'public/css/single.css',
        'public/css/ask.css',
        'public/css/aside.css',
        'public/css/tags.css',
    ];
    public $js = [
        'public/js/FloatingPanel.js',
        'public/js/SettingsLinksCustomize.js',
        'public/js/QuestionButtons.js',
    ];
    public $depends = [
        'app\assets\DependsAsset',
    ];
}
