<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StaticAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
    ];
    public $js = [
        'js/library.js',
        'js/retina.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

class StaticIEAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/html5.js',
        'js/respond.js',
    ];
    public $jsOptions = ['condition' => 'lte IE9'];
}
