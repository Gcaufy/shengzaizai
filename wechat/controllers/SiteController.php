<?php

namespace wechat\controllers;

use Yii;
use yii\log\Logger;
use yii\web\BadRequestHttpException;
use common\models\LoginAdmin;
use common\models\Password;
use wechat\models\UserWechat;
use wechat\components\Wechat;

class SiteController extends BaseController
{

    public function actionIndex()
    {
        $wechat = Yii::$app->wechat;
        $wechat->valid();

        $defaultMsg = '您好！欢迎关注生仔仔公众号！';
        $type = $wechat->getRev()->getRevType();
        $reply = '';
        switch ($type) {
            case Wechat::MSGTYPE_EVENT:
                $event = $wechat->getRevEvent();
                switch ($event['event']) {
                    case Wechat::EVENT_SUBSCRIBE:
                        $defaultMsg .= '请先在个人中心绑定您的帐户，然后及时修改您的初始密码';
                        $reply = $wechat->text($defaultMsg)->reply();
                        break;
                }
                break;
            case Wechat::MSGTYPE_TEXT:
                $content = $wechat->getRevContent();
                $reply = $wechat->text($content)->reply();
                //$reply = $wechat->transfer_customer_service()->reply();
                break;
        }

        return $reply;
    }

    public function actionLogin($code = null, $openid = null, $returnUrl = null)
    {
        if (is_string($code) && is_null($openid)) {
            $openid = $this->getOpenId();
        }
        if (!is_string($openid)) {
            return $this->render('msg', ['msg' => '无效的请求！']);
        }

        $user_wx = UserWechat::findOne($openid);
        if (isset($user_wx->user)) {
            return $this->render('msg', ['msg' => '您的微信已经绑定了帐号！']);
        }
        if (is_null($user_wx)) {
            $user_wx = new UserWechat();
            $user_wx->open_id = $openid;
        }

        $model = new LoginAdmin();
        if ($model->load(Yii::$app->request->post()) && $user_wx !== null) {
            if (isset($model->user)) {
                $encrypt = new \common\controllers\EncryptController();
                $model->password = $encrypt->admin($model->password, $model->user->authkey);
                if ($model->login()) {
                    $user_wx->user_id = $model->user->id;
                    $user_wx->save();
                    if (is_string($returnUrl) && strpos('site/login', $returnUrl) === false) {
                        $this->redirect($returnUrl);
                    } else {
                        return $this->render('msg', ['msg' => '绑定成功！']);
                    }
                } else {
                    return $this->render('msg', ['msg' => '绑定失败！请您检查您的用户名和密码输入是否正确']);
                }
            }
        }

        return $this->render('login', [
            'openid' => $openid,
            'returnUrl' => $returnUrl,
        ]);
    }

    public function actionLogout()
    {
        $this->switchIdentity();
        $user_wx = UserWechat::findOne(['user_id' => Yii::$app->user->identity->id]);
        if (isset($user_wx)) {
            $user_wx->user_id = null;
            $user_wx->save();
        }
        Yii::$app->user->logout();
        return $this->render('msg', ['msg' => '您已成功解除绑定！']);
    }

    public function actionInfo()
    {
        $this->switchIdentity();
        $info = [
            '姓名' => Yii::$app->user->identity->realname,
            '手机' => Yii::$app->user->identity->mobile,
        ];
        return $this->render('info', [
            'info' => $info,
        ]);
    }

    public function actionModifypassword()
    {
        $this->switchIdentity();

        $post = Yii::$app->request->post();
        $model = Password::findOne(Yii::$app->user->id);
        if ($model->load($post)) {
            if ($model->save()) {
                return $this->render('msg', ['msg' => '修改密码成功！']);
            }
            return $this->render('msg', ['msg' => '修改密码失败！']);
        }

        return $this->render('modifypassword');
    }

    public function actionTest() {
        echo 1;exit;
        Yii::getLogger()->log('test', Logger::LEVEL_INFO, 'wechat');
        return;

        return Yii::$app->wechat->createMenu([
            [
                'name' => '孕知识',
                'type' => 'view',
                'url' => 'http://www.baidu.com',
            ],
            [
                'name' => '预约问诊',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '预约特约医生',
                        'url' => 'http://www.baidu.com',
                    ],
                    [
                        'type' => 'view',
                        'name' => '预约医生',
                        'url' => 'http://www.baidu.com',
                    ],
                    [
                        'type' => 'view',
                        'name' => '预约检查',
                        'url' => 'http://www.baidu.com',
                    ],
                    [
                        'type' => 'view',
                        'name' => '预约手术',
                        'url' => 'http://www.baidu.com',
                    ],
                    [
                        'type' => 'view',
                        'name' => '快速预约',
                        'url' => 'http://www.baidu.com',
                    ],
                ],
            ],
            [
                'name' => '我的中心',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '绑定账号',
                        'url' => 'http://www.baidu.com',
                    ],
                    [
                        'type' => 'view',
                        'name' => '注册',
                        'url' => 'http://www.baidu.com',
                    ],
                    [
                        'type' => 'view',
                        'name' => '我的预约单',
                        'url' => 'http://www.baidu.com',
                    ],
                    [
                        'type' => 'view',
                        'name' => '我的钱包',
                        'url' => 'http://www.baidu.com',
                    ],
                    [
                        'type' => 'view',
                        'name' => '资讯医导',
                        'url' => 'http://www.baidu.com',
                    ],
                ],
            ],
        ]);
    }

}
