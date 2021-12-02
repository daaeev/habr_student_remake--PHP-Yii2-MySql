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
            'cookieValidationKey' => 'T_wmilelycM96lY97D6wkcstPKJCglEx',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
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
                'questions/<category:\D{0,11}>' => 'site/index',
                '' => 'site/index',
                'my/<category:\D{0,11}>' => 'site/my',
                'q/<id:\d+>' => 'site/single',
                'tags' => 'site/tags',
                't/<id:\d+>/<category:\D{0,11}>' => 'site/tag',
                'ask' => 'site/create-question',
                'profile/<id:\d+>/<chapter:\D{0,11}>' => 'site/profile',
                'login' => 'authorization/login',
                'registration' => 'authorization/registration',
                'logout' => 'authorization/logout',
                'forgot' => 'authorization/forgot',
                'change' => 'authorization/change-password',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
            ],
            'ignoreLanguageUrlPatterns' => [
                '#handler/sub-question#' => '#handler/sub-question#',
                '#handler/like#' => '#handler/like#',
                '#handler/sub-tag#' => '#handler/sub-tag#',
                '#handler/delete-comment#' => '#handler/delete-comment#',
                '#handler/comment-edit#' => '#handler/comment-edit#',
                '#handler/complain#' => '#handler/complain#',
                '#handler/approve-answer#' => '#handler/approve-answer#',
                '#handler/set-description#' => '#handler/set-description#',
                '#handler/forgot-password#' => '#handler/forgot-password#',
                '#handler/change-password#' => '#handler/change-password#',
            ],
        ],
        'i18n' => [
            'translations' => [
                'main' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'ru',
                ]
            ]
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => '', // Specify username
                'password' => '', //Specify password
                'port' => '587',
                'encryption' => 'tls',
            ] 
        ],
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
