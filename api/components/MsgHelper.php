<?php
namespace api\components;

use yii\helpers\ArrayHelper;

class MsgHelper {

    const FAILE = 0;
    const SUCCESS = 1;

    public static function success($msg = '', $data = []) {
        return self::output(['status' => self::SUCCESS], $msg, $data);
    }
    public static function faile($msg = '', $data = []) {
        return self::output(['status' => self::FAILE], $msg, $data);
    }

    protected static function output($arr, $msg, $data) {
        if (is_array($msg)) {
            $msg = null;
            $data = $msg;
        }
        if ($msg) {
            $arr['message'] = $msg;
        }
        return ArrayHelper::merge($arr, $data);
    }
}