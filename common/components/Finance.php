<?php
namespace common\components;

use Yii;
use common\models\finance\Balance;
use common\models\finance\Payment;
use common\models\finance\GeneralLedger;

class Finance
{
    private static $_errors = null;

    const PLATFORM = 1;

    const ERROR_INSUFFICIENT_BALANCE = '101';
    const ERROR_DB_BALANCE_UPDATE = '111';
    const ERROR_DB_GENERALLEDGER_INSERT = '112';
    const ERROR_DB_PAYMENT_INSERT = '113';

    protected static function errorDefine() {
        return [
            self::ERROR_INSUFFICIENT_BALANCE => '账户余额不足, 请充值',
            self::ERROR_DB_BALANCE_UPDATE => '更新余额失败, 请稍后再试.',
            self::ERROR_DB_GENERALLEDGER_INSERT => '数据更新出错, 请稍后再试.',
            self::ERROR_DB_PAYMENT_INSERT => '数据更新出错, 请稍后再试.',
        ];
    }


    public static function charge($amount) {
        return self::_record($amount, '用户充值', Payment::TYPE_CHARGE, self::PLATFORM);
    }

    public static function expense($amount, $desc) {
        return self::checkBalance($amount) ? self::_record($amount, $desc, Payment::TYPE_EXPENSE, self::PLATFORM) : null;
    }

    public static function pay($amount, $desc, $pay_to) {
        return self::checkBalance($amount) ? self::_record($amount, $desc, Payment::TYPE_EXPENSE, $pay_to) : null;
    }

    public static function checkBalance($amount) {
        $balance = Finance::getBalance();
        if ($balance < $amount && Yii::$app->user->identity->id != self::PLATFORM) {
            self::addError(self::ERROR_INSUFFICIENT_BALANCE);
            return false;
        }
        return true;
    }

    public static function getBalance($userId = null, $ismodel = false) {
        if (func_num_args() === 1) {
            $ismodel = $userId;
            $userId = null;
        }
        if (!$userId)
            $userId = Yii::$app->user->identity->id;

        $model = Balance::find()->andWhere(['user_id' => $userId])->one();
        if (!$model) {
            $model = new Balance();
            $model->user_id = $userId;
            $model->amount = 0;
        }
        return $ismodel ? $model : $model->amount;
    }

    public static function getErrors() {
        return self::$_errors;
    }

    public static function addError($code) {
        if (!self::$_errors)
            self::$_errors = [];
        $map = self::errorDefine();
        self::$_errors[$code] = $map[$code];
    }

    public static function clearError() {
        self::$_errors = null;
    }

    protected static function _record($amount, $desc, $type, $pay_to) {

        $income = $type == Payment::TYPE_CHARGE ? 1 : -1;
        $status = true;
        $orderNo = self::generateOrderNo($type);
        $tansaction = Yii::$app->db->beginTransaction();
        $payment = new Payment();
        $payment->user_id = Yii::$app->user->identity->id;
        $payment->pay_to = $pay_to;
        $payment->order_no = $orderNo;
        $payment->amount = $amount;
        $payment->type = $type;
        $payment->desc = $desc;

        if ($payment->save()) {
            $status = self::insertGL($payment) &&
                self::updateBalance($payment->user_id, $amount * $income) &&
                self::updateBalance($payment->pay_to, $amount * $income * -1);
        } else {
            $status = false;
            self::addError(self::ERROR_DB_PAYMENT_INSERT);
        }
        if ($status) {
            $tansaction->commit();
            self::clearError();
            return $orderNo;
        } else {
            $tansaction->rollback();
            return null;
        }

    }

    protected static function insertGL($payment) {
        $gl = new GeneralLedger();

        $gl->payment_id = $payment->id;
        $gl->order_no = $payment->order_no;
        $gl->amount = $payment->amount;

        $gl->user_id = $payment->user_id;
        $gl->direction = ($payment->type === Payment::TYPE_CHARGE ? GeneralLedger::DIRECTION_CREDIT : GeneralLedger::DIRECTION_DEBIT);

        if ($gl->save()) {
            $gl->id = null;
            $gl->isNewRecord = true;
            $gl->user_id = $payment->pay_to;
            $gl->direction = ($payment->type === Payment::TYPE_CHARGE ? GeneralLedger::DIRECTION_DEBIT : GeneralLedger::DIRECTION_CREDIT);
            if ($gl->save()) {
                return true;
            }
        }
        self::addError(self::ERROR_DB_GENERALLEDGER_INSERT);
        return false;
    }

    protected static function updateBalance($userId = null, $amount = 0) {
        if (func_num_args() === 1) {
            $amount = $userId;
            $userId = Yii::$app->user->identity->id;
        }

        $model = Finance::getBalance($userId, true);
        $model->amount += $amount;
        if ($model->save()) {
            return true;
        }
        self::addError(self::ERROR_DB_BALANCE_UPDATE);
        return false;
    }

    protected static function generateOrderNo($type) {
        // 18
        $timestr = date("YmdHis") . str_pad(floor(microtime()*1000), 4, '0', STR_PAD_LEFT);
        // 3
        $rand = mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
        // 1
        $orderno = $timestr . $type . $rand;
        if(Payment::find()->andWhere(['order_no' => $orderno])->one()) {
            return self::generateOrderNo($type);
        }
        return $orderno;
    }

}
