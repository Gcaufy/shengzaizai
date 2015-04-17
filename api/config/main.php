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
                'POST reset' => 'site/reset',
                'POST register' => 'site/register',
                'POST register/captcha' => 'site/captcha',
                'POST login' => 'site/login',
                'POST finance/charge' => 'finance/charge',
                'POST finance/expense' => 'finance/expense',
                'POST order' => 'order/create',
                'POST order/instruction' => 'order/instruction',
                'DELETE order/<id:\d+>' => 'order/cancel',
                'POST coment' => 'coment/create',
                'POST feedback' => 'feedback/create',
                'POST article/positive' => 'article/positive',
                'PUT user/profile' => 'user/update',
                'PUT user/password' => 'user/password',

                'GET finance/balance' => 'finance/balance',
                'GET finance/ledger' => 'finance/ledger',
                'GET system/info' => 'system/info',
                'GET hospital/inspection' => 'hospital/inspection',
                'GET hospital/operation' => 'hospital/operation',
                'GET doctor/all' => 'doctor/all',
                'GET user/profile' => 'user/profile',
                'GET openorder/currentweek' => 'openorder/currentweek',
                'GET openorder/currentmonth' => 'openorder/currentmonth',
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
                        'register',
                        'finance',
                        'region',
                        'hospital',
                        'doctor',
                        'inspection',
                        'operation',
                        'openorder',
                        'order',
                        'comment',
                        'favor',
                    ],
                    'pluralize' => false,
                ],
            ],
        ]
    ],
    'params' => $params,
];
