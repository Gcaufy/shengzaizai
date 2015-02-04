<?php
namespace backend\components;

use Yii;
use yii\helpers\Url;
use common\models\User;

class Html extends \yii\helpers\Html {

    public static function a($text, $url = null, $options = [])
    {
        if (User::checkAction(Url::to($url)))
            return parent::a($text, $url, $options);
    }

}
