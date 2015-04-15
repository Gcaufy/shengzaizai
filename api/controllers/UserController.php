<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use common\models\UserToken;
use yii\filters\VerbFilter;
use common\models\SmsCaptcha;
use api\components\MsgHelper;

/**
 * Site controller
 */
class UserController extends BaseController
{
    public $modelClass = 'api\models\User';
    protected $loginRequired = true;

    public function actions() {
        return [];
    }


    public function actionProfile() {
        return $this->getQuery()->andWhere(['t.id' => Yii::$app->user->identity->id])->one();
    }

    public function actionUpdate() {
        $user = Yii::$app->user->identity;
        $user->scenario = 'update_profile';
        if ($user->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($user->save()) {
                return MsgHelper::success('更新成功.');
            } else {
                return MsgHelper::faile('更新失败.', $user->getErrors());
            }
        }
        return MsgHelper::faile('参数错误.');
    }

    public function actionPassword() {
        $user = Yii::$app->user->identity;
        $old_password = Yii::$app->getRequest()->getBodyParam('password');
        $user->scenario = 'update_password';
        if (!$old_password || $user->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if (!$user->validatePassword($old_password)) {
                return MsgHelper::success('原始密码错误.');
            }
            if ($user->validate()) {
                $user->setPassword($user->new_password);
                if ($user->save())
                    return MsgHelper::success('更新成功.');
            }
            return MsgHelper::faile('更新失败.', $user->getErrors());
        }
        return MsgHelper::faile('参数错误.');

    }

}
