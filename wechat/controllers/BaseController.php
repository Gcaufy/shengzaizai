<?php

namespace wechat\controllers;

use Yii;
use common\models\User;
use common\models\UserActionTrace;
use common\models\UserWechat;

class BaseController extends \yii\web\Controller
{
    private $_wechat;


    public function init() {
        parent::init();
        $this->on(self::EVENT_BEFORE_ACTION, [$this, 'evtBeforeAction']);
    }

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

    public function getWechat() {
        if ($this->_wechat)
            return $this->_wechat;
        $this->_wechat = Yii::$app->wechat;
        return $this->_wechat;
    }

    public function evtBeforeAction($event) {
        $controller = $event->sender;
        $wechat = $controller->wechat->getRev();
        $openId = $wechat->getRevFrom();
        $model = UserWechat::find()->joinWith('user')->andWhere(['t.open_id' => $openId])->one();
        if ($model && $model->user)
            Yii::$app->user->identity = $model->user;
        $event->isValid = true;
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
