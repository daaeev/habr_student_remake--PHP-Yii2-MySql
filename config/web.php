<?php

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => '@app/views/layouts/admin',
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'user' => [
            'loginUrl' => '/login',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => $db,
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['ru', 'en'],
            'enableDefaultLanguageUrlCode' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'questions/<category:\D{0,11}>' => 'site/index',
                'my/<category:\D{0,11}>' => 'site/my',
                'q/<id:\d+>' => 'site/single',
                'tags' => 'site/tags',
                't/<id:\d+>/<category:\D{0,11}>' => 'site/tag',
                'ask' => 'site/create-question',
                'profile/<id:\d+>/<chapter:\D{0,11}>' => 'site/profile',
                'login' => 'authorization/login',
                'registration' => 'authorization/registration',
                'logout' => 'authorization/logout',
            ],
            'ignoreLanguageUrlPatterns' => [
                '#handler/sub-question#' => '#handler/sub-question#',
                '#handler/like#' => '#handler/like#',
                '#handler/sub-tag#' => '#handler/sub-tag#',
                '#handler/delete-comment#' => '#handler/delete-comment#',
                '#handler/comment-edit#' => '#handler/comment-edit#',
                '#handler/complain#' => '#handler/complain#',
                '#handler/approve-answer#' => '#handler/approve-answer#',
            ],
        ],
        'i18n' => [
            'translations' => [
                'main' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'ru',
                ]
            ]
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
