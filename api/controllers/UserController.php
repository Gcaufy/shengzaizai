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
    public $modelClass = '\common\models\User';
    protected $loginRequired = true;

    public function actions() {
        return [];
    }


    public function actionProfile() {
        $arr = $this->getQuery()->asArray()->andWhere(['t.id' => Yii::$app->user->identity->id])->one();
        $deniedFields = ['auth_key', 'password', 'payment_password', 'role', 'status', 'utime', 'uid', 'ctime', 'cid'];
        foreach ($deniedFields as $key => $value) {
            unset($arr[$value]);
        }
        if ($arr['portrait'])
            $arr['portrait_url'] = 'http:' . Yii::$app->urlManager->baseUrl . '/file?thumb=138x138&id=' . $arr['portrait'];
        return $arr;
    }

}
