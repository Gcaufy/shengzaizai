<?php

if (isset($_SERVER['HTTP_HOST'])) {
    // $_SERVER["HTTP_HOST"] is not defined in php command line mode
    $host = explode('.', $_SERVER["HTTP_HOST"]);
    if (count($host) > 2) {
        define('DOMAIN', $host[1] . '.' . $host[2]);
    } else {
        define('DOMAIN', $host[0] . '.' . $host[1]);
    }
} else {
    // never used in command line mode
    define('DOMAIN', 'imnbee.com');
}

define('DOMAIN_HOME', 'www.' . DOMAIN);
define('DOMAIN_USER_CENTER', 'man.' . DOMAIN);
define('DOMAIN_API', 'api.' . DOMAIN);
define('DOMAIN_WECHAT', 'wx.' . DOMAIN);
define('DOMAIN_EMAIL', 'mail.' . DOMAIN);
define('DOMAIN_IMG', 'img.' . DOMAIN);

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'zh-CN',
    'timeZone'=>'Asia/Chongqing',
    'controllerMap' => [
        'file' => 'mdm\\upload\\FileController',
    ],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true, 'domain' => '.' . DOMAIN],
        ],
        'session' => array(
            'class' => 'yii\web\Session',
            'cookieParams' => array('domain' => '.' . DOMAIN, 'lifetime' => 0),
            'timeout' => 3600,
        ),
        'sms' => [
            'class' => 'backend\components\Sms',
            'sn' => '<sn>',
            'password' => '<password>',
            'sign' => '生仔仔',
        ],
        'cache' => [
            'class' => 'yii\caching\DbCache',
            'cacheTable' => 'sys_cache',
        ],
        'urlManager' => [
            'class' => 'common\components\MutilpleDomainUrlManager',
            'domains' => [
                'www' => '//' . DOMAIN_HOME,
                'man' => '//' . DOMAIN_USER_CENTER,
                'mail' => '//' . DOMAIN_EMAIL,
                'img' => '//' . DOMAIN_IMG,
                'api' => '//' . DOMAIN_API,
                'wx' => '//' . DOMAIN_WECHAT,
            ],
            'baseUrl' => '//' . DOMAIN_HOME,
            'showScriptName' => false,
            'enablePrettyUrl' => true,
        ],
        'authManager' => [
            'class' => 'common\components\PhpManager',
            'itemFile' => '@common/rbac/items.php',
            'defaultRoles' => ['guest'],
            'roleMap' => [
                '1' => 'admin',
                '2' => 'normal',
            ],
        ],
    ],
];
