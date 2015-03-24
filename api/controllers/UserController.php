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

}
