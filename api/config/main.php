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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'login',
                    'pluralize' => false,
                    'patterns' => ['GET' => 'index'],
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
                        'site',
                    ],
                    'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['message'],
                    'pluralize' => false,
                    'extraPatterns' => ['GET user' => 'user'],
                ],
            ],
        ]
    ],
    'params' => $params,
];
