<?php

namespace wechat\controllers;

use Yii;
use common\models\User;
use common\models\UserActionTrace;
use wechat\models\UserWechat;

class BaseController extends \yii\web\Controller
{

    protected function getOpenId()
    {
        $access_token = Yii::$app->wechat->getOauthAccessToken();
        if (isset($access_token['openid']))
            return $access_token['openid'];
        return null;
    }

    protected function switchIdentity()
    {
        if (!Yii::$app->user->isGuest)
            return;
        if ($this->id !== 'site' || $this->action->id !== 'login') {
            $url = ['returnUrl' => Yii::$app->request->absoluteUrl];
        } else {
            $url = [];
        }
        $openid = $this->getOpenId();
        if (isset($openid)) {
            $user_wx = UserWechat::findOne($openid);
            $url['openid'] = $openid;
        }
        if (empty($user_wx->user)) {
            array_unshift($url, 'site/login');
            $this->redirect($url);
        }
        Yii::$app->user->switchIdentity($user_wx->user);
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        //UserActionTrace::touch('wechat', $this->id, $action->id, $this->module->id);
        return parent::afterAction($action, $result);
    }

}
