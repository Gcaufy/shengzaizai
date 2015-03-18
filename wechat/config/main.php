<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-wechat',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'wechat\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'wechat' => [
            'class' => 'wechat\components\Wechat',
            'appId' => '微信公众平台中的appid',
            'appSecret' => '微信公众平台中的secret',
            'token' => '微信服务器对接您的服务器验证token'
        ],
        'request' => [
            'enableCsrfValidation' => false,
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
            'baseUrl' => '//' . DOMAIN_WECHAT,
        ],
    ],
    'params' => $params,
];
