<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \common\models\finance\GeneralLedger;
use \common\models\finance\Payment;
use \common\components\Finance;
use yii\data\ActiveDataProvider;
use api\components\MsgHelper;

/**
 * GeneralLedgerController
 */
class FinanceController extends BaseController
{
    public $modelClass = '\common\models\finance\Payment';
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

    public function actionLedger() {
        $query = GeneralLedger::find()->andWhere(['t.user_id' => Yii::$app->user->identity->id]);
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    public function actionCharge() {
        $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
        if (!$amount) {
            return MsgHelper::faile('参数错误');
        }
        $orderNo = Finance::charge($amount);
        $errors = Finance::getErrors();
        if (!$errors)
            return MsgHelper::success('充值成功', ['order_no' => $orderNo]);
        else
            return MsgHelper::faile('充值出错', ['errors' => $errors]);
    }


    public function actionExpense() {
        $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
        $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
        if (!$amount) {
            return MsgHelper::faile('参数错误');
        }
        $orderNo = Finance::expense($amount, $desc);
        $errors = Finance::getErrors();
        if (!$errors)
            return MsgHelper::success('消费成功', ['order_no' => $orderNo]);
        else
            return MsgHelper::faile('消费出错', ['errors' => $errors]);
    }

}
