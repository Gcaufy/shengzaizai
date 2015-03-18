<?php

namespace wechat\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use common\models\LoginAdmin;
use common\models\Password;
use wechat\models\UserWechat;
use Wechat;

class SiteController extends BaseController
{

    public function actionIndex()
    {
        $wechat = Yii::$app->wechat;
        $wechat->valid();

        $defaultMsg = '您好！欢迎您来到蜜蜂家长会！蜜蜂家长会是一个全新的家校沟通平台，在这里，您可以获取最新教育资讯，及时掌握学校通知，随时随地了解学生学习情况，便捷地与老师（家长）沟通。让教育更高效，成长更轻松！如需帮助，请回复“帮助”并加上您的疑问。蜜蜂会及时回复！';
        $type = $wechat->getRev()->getRevType();
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
                $reply = $wechat->transfer_customer_service()->reply();
                break;
        }

        return isset($reply) ? $reply : '';
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

}
