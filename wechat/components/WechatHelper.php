<?php
namespace wechat\components;

use Yii;
use yii\web\HttpException;
use common\models\User;
use common\models\UserWechat;
use common\models\SmsCaptcha;

class WechatHelper {

    public static function onReceiveText($event) {
        $wechat = $event->sender;
        $content = $wechat->getRevContent();
        $openId = $wechat->getRevFrom();

        // 此消息来自公共号
        if ($openId === 'gh_f7bf744946a2') {
            return;
        }
        $userWechat = UserWechat::findModel($openId);
        $msg = $content;

        // 5 分钟输入状态失效.
        if (time() - $userWechat->utime >= 5 * 60) {
            $userWechat->process = UserWechat::PROCESS_NEW;
            if (!$userWechat->save())
                $wechat->throwError($userWechat->getError());
        }
        switch ($userWechat->process) {
            case UserWechat::PROCESS_LOGIN:
                $data = explode('#', $content);
                if (count($data) !== 2)
                    $wechat->throwError('您输入的格式不正确, 请回复""您的手机号"[#]"您的登录密码"进行绑定. 如: "13866668888#123456".');
                $user = User::findByMobile($data[0]);
                if (!$user || $user->validatePassword($data[1]))
                    $wechat->throwError('您输入的用户名或者密码不对, 请重新输入.');
                $userWechat->user_id = $user->id;
                $userWechat->process = UserWechat::PROCESS_BIND;
                if (!$userWechat->save())
                    $wechat->throwError($userWechat->getError());
                $msg = '您的账户已成功绑定.';
                break;
            case UserWechat::PROCESS_REGIST:
                $data = explode('#', $content);
                if (count($data) !== 2)
                    $wechat->throwError('您输入的格式不正确, 请回复"您的真实姓名"[#]"您的手机号"来注册绑定账户. 如: "张三#13866668888".');
                $name = $data[0];
                $mobile = $data[1];
                if (!preg_match("/1[3458]{1}\d{9}$/", $mobile)) {
                    $wechat->throwError('无效手机号码, 请回复"您的真实姓名"[#]"您的手机号"来注册绑定账户. 如: "张三#13866668888".');
                }
                $user = User::findByMobile($mobile);
                // 用户已存在
                if ($user) {
                    $userWechat->process = UserWechat::PROCESS_NEW;
                    if (!$userWechat->save())
                        $wechat->throwError($userWechat->getError());
                    $wechat->throwError('该手机号已被注册. 请前往[个人中心]->[绑定账号]进行账号绑定.');
                }
                $captcha = new SmsCaptcha();
                $captcha->mobile = $mobile;
                $captcha->type = SmsCaptcha::TYPE_REGISTER;
                $data['captcha'] = $captcha->captcha;
                $userWechat->data = serialize($data);
                $userWechat->process = UserWechat::PROCESS_VALIDATE;
                if (!$userWechat->save())
                    $wechat->throwError($userWechat->getError());

                $msg = "6位验证码已通过短信形式发送到您手机, 回复该验证码完成注册.";

                // 验证码已过期
                if (!$captcha->checkExsit()) {
                    $rrid = Yii::$app->sms->send($captcha->mobile, "用户注册校验码 {$captcha->captcha}");
                    $error = Yii::$app->sms->getError($rrid);
                    if (!is_null($error)) {
                        $wechat->throwError([$error]);
                    }
                }
                break;
            case UserWechat::PROCESS_VALIDATE:
                $data = unserialize($userWechat->data);
                if ($data['captcha'] !== $content)
                    $wechat->throwError('您输入的验证码有误, 请重新输入.');
                $user = new User();
                $data = ['name' => $data[0], 'mobile' => $data[1]];
                $user->realname = $data['name'];
                $user->mobile = $data['mobile'];
                $user->role = User::ROLE_NORMAL;
                $password = mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
                $user->setPassword($password);
                if (!$user->save())
                    $wechat->throwError($user->getErrors());

                $userWechat->user_id = $user->id;
                $userWechat->process = UserWechat::PROCESS_BIND;
                if (!$userWechat->save())
                    $wechat->throwError($userWechat->getError());

                $msg = "您已注册并且绑定成功, 您的初始登陆密码为$password." ;

            default:
                # code...
                break;
        }
        echo $wechat->text($msg)->reply();
    }

    public static function onSubscribe($event) {
        $wechat = $event->sender;
        $openId = $wechat->getRevFrom();
        // Create new user wechat
        $userWechat = UserWechat::findModel($openId);
        $msg = '生仔仔欢迎您! 您可以点击下列菜单, 选择服务, 如需咨询医导, 请回复: "资询"+"您的年龄"+"男/女"+"您的问题". 请先在个人中心绑定您的帐户，然后及时修改您的初始密码';
        $reply = $wechat->text($msg)->reply();
        echo $reply;
    }

    public static function onMenuClick($event) {
        $wechat = $event->sender;
        $menu = $wechat->getRevEvent();
        $openId = $wechat->getRevFrom();
        $msg = '您的账户已经绑定.';
        switch ($menu['key']) {
            case 'KEY_USE_BIND':
                $userWechat = UserWechat::findModel($openId);
                if ($userWechat->process != UserWechat::PROCESS_BIND) {
                    $userWechat->process = UserWechat::PROCESS_LOGIN;
                    if (!$userWechat->save())
                        $wechat->throwError($userWechat->getError());
                    $msg = '未注册用户请前往[个人中心]->[注册], 注册新用户. 如果您已注册生仔仔账户, 请回复""您的手机号"[#]"您的登录密码"进行绑定. 如: "13866668888#123456"';
                }
                break;
            case 'KEY_USER_REGIST':
                $userWechat = UserWechat::findModel($openId);
                if ($userWechat->process != UserWechat::PROCESS_BIND) {
                    $userWechat->process = UserWechat::PROCESS_REGIST;
                    if (!$userWechat->save())
                        $wechat->throwError($userWechat->getError());
                    $msg = '为确保您能够成功预约, 请回复"您的真实姓名"[#]"您的手机号"来注册绑定账户. 如: "张三#13866668888".';
                }
                break;
        }
        echo $wechat->text($msg)->reply();
    }
}