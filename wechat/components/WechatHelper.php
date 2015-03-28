<?php
namespace wechat\components;

use Yii;
use yii\web\HttpException;
use common\models\User;
use common\models\UserWechat;
use common\models\SmsCaptcha;
use common\models\File;

use \backend\modules\doctor\models\Doctor;
use \backend\modules\doctor\models\DoctorTitle;
use \backend\modules\doctor\models\DoctorTitleMap;
use \backend\modules\hospital\models\Hospital;
use \backend\modules\order\models\Number;
use \backend\modules\order\models\Order;

class WechatHelper {

    public static function onReceiveText($event) {
        $wechat = $event->sender;
        $content = $wechat->getRevContent();
        $openId = $wechat->getRevFrom();
        $user = Yii::$app->user->identity;

        // 此消息来自公共号
        if ($openId === 'gh_f7bf744946a2') {
            return;
        }
        $userWechat = UserWechat::findModel($openId);
        $msg = '帮助: 这个是用户随意输入之后的系统自动回复. 可放帮助文字.';

        // 10 分钟输入状态失效.
        if (time() - $userWechat->utime >= 10 * 60 && $userWechat->process != UserWechat::PROCESS_BIND) {
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
                if (!$user || !$user->validatePassword($data[1]))
                    $wechat->throwError('您输入的用户名或者密码不对, 请重新输入.');
                $userWechat->user_id = $user->id;
                $userWechat->process = UserWechat::PROCESS_BIND;
                if (!$userWechat->save())
                    $wechat->throwError($userWechat->getError());
                $msg = '您的账户已成功绑定.';
                if (!$user->portrait) {
                    $info = $wechat->getMemberInfo($openId);
                    $file = File::download($info['headimgurl'], $user->id, 'portrait');
                    $user->portrait = $file->id;
                    $user->save();
                }
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
                if (false && $data['captcha'] !== $content)
                    $wechat->throwError('您输入的验证码有误, 请重新输入.');
                $user = new User();
                $data = ['name' => $data[0], 'mobile' => $data[1]];
                //$data = ['name' => 'gc', 'mobile'=> '13590325927'];
                $user->realname = $data['name'];
                $user->mobile = $data['mobile'];
                $user->role = User::ROLE_NORMAL;
                $password = mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
                $user->setPassword($password);
                $info = $wechat->getMemberInfo($openId);
                $file = File::download($info['headimgurl'], $user->id, 'portrait');
                $user->portrait = $file->id;
                $user->from = User::FROM_WECHAT;

                if (!$user->save())
                    $wechat->throwError($user->getErrors());

                $userWechat->user_id = $user->id;
                $userWechat->process = UserWechat::PROCESS_BIND;
                $userWechat->data = '';
                if (!$userWechat->save())
                    $wechat->throwError($userWechat->getError());

                $msg = "您已注册并且绑定成功, 您的初始登陆密码为$password." ;
            case UserWechat::PROCESS_ORDER_VIEW:
                $data = unserialize($userWechat->data);
                if (!isset($data[$content]))
                    $wechat->throwError('您输入的序号有误, 请重新输入.');

                $doctor_id = $data[$content]['doctor_id'];
                $doctor_name = $data[$content]['doctor_name'];
                $month = date('m');
                $year = date('Y');
                $date = date('Y-m-d');
                $rows = Number::find()->select(['id', 'date', 'cost', 'active_order_num'])
                    ->andWhere(['doctor_id' => $doctor_id])
                    ->andWhere("SUBSTR(date, 1, 4) = $year and DATEDIFF(date, '$date') > 0 and SUBSTR(date, 6, 2) <= $month + 1 and active_order_num > 0")
                    ->asArray()
                    ->all();
                $data = [];
                $msg = '';
                $total = 0;
                $cost = 0;
                foreach ($rows as $key => $value) {
                    $key++;
                    $cost = $value['cost'];
                    $data[$key] = $value['id'];
                    $total += $value['active_order_num'];
                    $msg .= "$key {$value['date']} (还剩 {$value['active_order_num']} )\r\n";
                }
                $userWechat->process = UserWechat::PROCESS_ORDER_SELECT_DATE;
                $userWechat->data = serialize($data);
                if (!$userWechat->save())
                    $wechat->throwError($userWechat->getError());
                $msg = "特约医生 {$doctor_name} 本期还有 {$total} 个可用预约号, 费用为 {$cost} 元, 就诊日期如下, 回复日期前的序列号进行选择 : \r\n" . $msg;
                break;
            case UserWechat::PROCESS_ORDER_SELECT_DATE:
                $data = unserialize($userWechat->data);
                if (!isset($data[$content]))
                    $wechat->throwError('您输入的序号有误, 请重新输入.');

                $openOrderId = $data[$content];

                $userWechat->process = UserWechat::PROCESS_BIND;
                $userWechat->data = null;
                if (!$userWechat->save())
                    $wechat->throwError($userWechat->getError());

                $rst = Order::createOrder($openOrderId);
                if ($rst instanceof Order) {
                    $msg = "预约成功!\r\n" .
                        "就诊人: {$user->realname}\r\n" .
                        "手机号: {$user->mobile}\r\n" .
                        "医院: {$rst->hosp_name}\r\n" .
                        "医生: {$rst->doctor_name}\r\n" .
                        "就诊日期: {$rst->date}\r\n" .
                        "费用: {$rst->cost}\r\n" .
                        "挂号订单号: {$rst->order_no}\r\n\r\n" .
                        "您可在 [我的中心]->[我的预约单] 查询或取消本次预约.";
                    break;
                }

                if ($rst === Order::ERROR_NO_ACTIVE_NUM)
                    $wechat->throwError('此预约号已被预约完.');
                if ($rst === Order::ERROR_EXISTS)
                    $wechat->throwError('已成功预约此项, 请勿重复预约.');
                $wechat->throwError('系统出错, 请联系管理员.');
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
        $user = Yii::$app->user->identity;
        $userWechat = UserWechat::findModel($openId);
        $msg = '您的账户已经绑定.';
        switch ($menu['key']) {
            case 'KEY_USE_BIND':
                if ($userWechat->process != UserWechat::PROCESS_BIND) {
                    $userWechat->process = UserWechat::PROCESS_LOGIN;
                    if (!$userWechat->save())
                        $wechat->throwError($userWechat->getError());
                    $msg = '未注册用户请前往[个人中心]->[注册], 注册新用户. 如果您已注册生仔仔账户, 请回复""您的手机号"[#]"您的登录密码"进行绑定. 如: "13866668888#123456"';
                }
                break;
            case 'KEY_USER_REGIST':
                if ($userWechat->process != UserWechat::PROCESS_BIND) {
                    $userWechat->process = UserWechat::PROCESS_REGIST;
                    if (!$userWechat->save())
                        $wechat->throwError($userWechat->getError());
                    $msg = '为确保您能够成功预约, 请回复"您的真实姓名"[#]"您的手机号"来注册绑定账户. 如: "张三#13866668888".';
                }
                break;
            case 'KEY_ORDER':
                if ($user) {
                    $userWechat->process = UserWechat::PROCESS_ORDER_VIEW;

                    $month = date('m');
                    $year = date('Y');
                    $date = date('Y-m-d');
                    $rows = (new \yii\db\Query())
                        ->select(['sd.id', 'doctor_name' => 'sd.name', 'hospital_name' => 'sh.name', 'title_name' => 'group_concat(sdt.name)'])
                        ->from(Doctor::tableName() . ' sd')
                        ->leftJoin(Hospital::tableName() . ' sh', 'sd.hosp_id = sh.id')
                        ->leftJoin(DoctorTitleMap::tableName() . ' sdtm', 'sd.id = sdtm.doctor_id')
                        ->leftJoin(DoctorTitle::tableName() . ' sdt', 'sdt.id = sdtm.title_id')
                        ->leftJoin(Number::tableName() . ' son', 'sd.id = son.doctor_id')
                        ->where(['sd.isvip' => 1])
                        ->andWhere("SUBSTR(son.date, 1, 4) = $year and DATEDIFF(son.date, '$date') > 0 and SUBSTR(son.date, 6, 2) <= $month + 1")
                        ->groupBy('sd.id')
                        ->having('sum(son.active_order_num) > 0')
                        ->all();
                    $data = [];
                    $msg = '';
                    foreach ($rows as $key => $value) {
                        $key++;
                        $data[$key] = ['doctor_id' => $value['id'], 'doctor_name' => $value['doctor_name']];
                        $msg .= "$key {$value['doctor_name']} ({$value['hospital_name']} {$value['title_name']})\r\n";
                    }
                    if ($data) {
                        $userWechat->data = serialize($data);
                        if (!$userWechat->save())
                            $wechat->throwError($userWechat->getError());
                        $msg = "选择特约医生, 回复医生名字前序号: \r\n" . $msg;
                    }
                    else
                        $msg = "特约医生本期已约满, 下期特约号即将开放, 敬请关注. \r\n或者选择 \"预约医生\" 预约其它医生.";
                } else {
                    $msg = '您还没有绑定用户, 为确保您能够成功预约, 请前往[个人中心] 进行绑定或注册.';
                }
                break;
        }
        echo $wechat->text($msg)->reply();
    }
}