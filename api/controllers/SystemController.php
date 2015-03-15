<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \common\models\finance\GeneralLedger;
use \common\models\Config;

/**
 * GeneralLedgerController
 */
class SystemController extends BaseController
{
    public $modelClass = '\backend\modules\system\models\Region';
    protected $loginRequired = false;

    public function actions() {
        return [];
    }

    public function actionInfo() {
        $model = Config::find()->one();
        unset($model->id, $model->status, $model->uid, $model->cid, $model->ctime);
        return $model;
    }
}
