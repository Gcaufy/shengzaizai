<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \common\models\finance\GeneralLedger;
use \common\components\Finance;

/**
 * GeneralLedgerController
 */
class FinanceController extends BaseController
{
    public $modelClass = '\common\models\finance\GeneralLedger';
    protected $loginRequired = true;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }

    protected function getQuery() {
        $query = parent::getQuery();
        return $query->andWhere(['t.user_id' => Yii::$app->user->identity->id]);
    }

    public function actionBalance() {
        $balance = Finance::getBalance(true);
        return ['amount' => $balance->amount, 'utime' => $balance->utime];
    }
}
