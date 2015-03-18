<?php
namespace wechat\components;

use yii\web\HttpException;

class Wechat extends BaseWechat {

    public function valid() {
        $encryptStr="";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
        } else {
            if ($this->checkSignature()) {
                if (isset($_GET['echostr'])) {
                    die($_GET['echostr']);
                }
            } else
                throw new HttpException(500, 'Signature is wrong.');
        }
    }
}