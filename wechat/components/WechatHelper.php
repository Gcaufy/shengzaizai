<?php
namespace wechat\components;

use yii\web\HttpException;

class WechatHelper {

    public static function onReceiveText($event) {
        $wechat = $event->sender;
        $content = $wechat->getRevContent();
        echo $wechat->text($content)->reply();
    }

    public static function onSubscribe($event) {
        $wechat = $event->sender;
        $msg = '生仔仔欢迎您! 您可以点击下列菜单, 选择服务, 如需咨询医导, 请回复: "资询"+"您的年龄"+"男/女"+"您的问题". 请先在个人中心绑定您的帐户，然后及时修改您的初始密码';
        $reply = $wechat->text($msg)->reply();
        echo $reply;
    }

    public static function onMenuClick($event) {
        $wechat = $event->sender;
        $menu = $wechat->getRevEvent();
        echo $wechat->text($menu['key'])->reply();
    }

}