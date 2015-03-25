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
                'GET finance/ledger' => 'finance/ledger',
                'POST finance/charge' => 'finance/charge',
                'POST finance/expense' => 'finance/expense',
                'GET system/info' => 'system/info',
                'GET hospital/inspection' => 'hospital/inspection',
                'GET hospital/operation' => 'hospital/operation',
                'GET doctor/all' => 'doctor/all',
                'GET user/profile' => 'user/profile',
                'GET openorder/currentweek' => 'openorder/currentweek',
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
                    ],
                    'pluralize' => false,
                ],
            ],
        ]
    ],
    'params' => $params,
];
