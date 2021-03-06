<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use api\models\User;
use common\models\UserToken;
use yii\filters\VerbFilter;
use common\models\SmsCaptcha;
use api\components\MsgHelper;

/**
 * Register controller
 */
class SiteController extends BaseController
{
    public $modelClass = '';
    protected $loginRequired = false;


    public function actions()
    {
        return [];
    }

    public function actionCaptcha() {
        $params = Yii::$app->getRequest()->getBodyParams();
        if (!isset($params['mobile'])) {
            return MsgHelper::faile('手机号不能为空.');
        }
        $type = (isset($_GET['action']) && $_GET['action'] == 'reset') ? SmsCaptcha::TYPE_RESET_PASSWORD : SmsCaptcha::TYPE_REGISTER;
        $captcha = new SmsCaptcha();
        $captcha->mobile = $params['mobile'];
        $captcha->type = SmsCaptcha::TYPE_REGISTER;
        if ($captcha->checkExsit()) {
            return MsgHelper::faile('请求验证码过于频繁');
        }
        if ($captcha->save()) {
            $rrid = Yii::$app->sms->send($captcha->mobile, "用户注册校验码 {$captcha->captcha}");
            $error = Yii::$app->sms->getError($rrid);
            if (is_null($error)) {
                return MsgHelper::success('验证码已发送', ['captcha' => $captcha->captcha]);
            } else {
                return MsgHelper::faile("验证码发送失败，失败原因为：{$error}");
            }
        } else {
            return MsgHelper::faile('系统出错');
        }
    }

    public function actionRegister() {
        $params = Yii::$app->getRequest()->getBodyParams();
        if (!isset($params['captcha'])) {
            return MsgHelper::faile('验证码不能为空.');
        }
        if (!isset($params['mobile'])) {
            return MsgHelper::faile('手机号不能为空.');
        }
        if (!isset($params['password'])) {
            return MsgHelper::faile('密码不能为空.');
        }
        $captcha = $params['captcha'];
        $mobile = $params['mobile'];
        $password = $params['password'];
        $model = SmsCaptcha::getCaptcha($captcha, $mobile, SmsCaptcha::TYPE_REGISTER);
        if (!$model) {
            return MsgHelper::faile('验证码出错.');
        }
        // captcha expired after 3 mins
        if (time() - $model->ctime > 60 * 30) {
            return MsgHelper::faile('验证码已过期.');
        }
        $user = new User();
        $user->mobile = $mobile;
        $user->setPassword($password);
        $user->role = User::ROLE_NORMAL;
        $user->from = User::FROM_IOS;
        if ($user->save()) {
            return MsgHelper::success('注册成功');
        } else {
            return MsgHelper::faile('注册失败', ['error' => $user->getErrors()]);
        }
    }

    public function actionLogin() {
        $user = new User();
        $user->load(Yii::$app->request->post(), '');
        $password = $user->password;
        $user = User::findByMobile($user->mobile);
        if($user && $user->validatePassword($password) && $user->login()){
            $token = UserToken::updateToken($user->id);
            $arr = $user->toArray();
            $arr['token'] = $token;
            return $arr;
        } else {
            return MsgHelper::faile('用户名或者密码错误.');
        }
    }

    public function actionReset() {
        $captcha = $params['captcha'];
        $mobile = $params['mobile'];
        $password = $params['password'];
        $model = SmsCaptcha::getCaptcha($captcha, $mobile, SmsCaptcha::TYPE_RESET_PASSWORD);
        if (!$model) {
            return MsgHelper::faile('验证码出错.');
        }
        // captcha expired after 3 mins
        if (time() - $model->ctime > 60 * 3) {
            return MsgHelper::faile('验证码已过期.');
        }
        $user = User::findByMobile($mobile);
        if (!$user) {
            return MsgHelper::faile('用户不存在.');
        }
        $user->setPassword($password);
        if ($user->save()) {
            return MsgHelper::success('修改密码成功');
        } else {
            return MsgHelper::faile('修改密码失败', ['error' => $user->getErrors()]);
        }
    }
}
