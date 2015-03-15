<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'system' => ['class' => 'backend\modules\system\System'],
        'cms' => ['class' => 'backend\modules\cms\Cms'],
        'member' => ['class' => 'backend\modules\member\Member'],
        'user' => ['class' => 'backend\modules\user\User'],
        'hospital' => ['class' => 'backend\modules\hospital\Hospital'],
        'doctor' => ['class' => 'backend\modules\doctor\Doctor'],
        'operation' => ['class' => 'backend\modules\operation\Operation'],
        'inspection' => ['class' => 'backend\modules\inspection\Inspection'],
    ],
    'components' => [
        /*'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],*/
        'urlManager' => [
            'baseUrl' => '//' . DOMAIN_HOME,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
