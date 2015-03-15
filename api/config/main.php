<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
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
        'urlManager' => [
            'baseUrl' => '//' . DOMAIN_API,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'POST register' => 'site/register',
                'POST register/captcha' => 'site/captcha',
                'POST login' => 'site/login',
                'GET finance/balance' => 'finance/balance',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'pluralize' => false,
                    'patterns' => [
                        'POST captcha' => 'captcha',
                        'POST register' => 'register',
                        'POST login' => 'login',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'article',
                    'pluralize' => false,
                    'patterns' => [
                        'GET category' => 'category',
                        'GET all' => 'all',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'article',
                        'class',
                        'homework',
                        'note',
                        'register',
                        'finance',
                    ],
                    'pluralize' => false,
                ],
            ],
        ]
    ],
    'params' => $params,
];
