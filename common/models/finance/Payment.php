<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "{{%fin_payment}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $order_no
 * @property string $amount
 * @property string $type
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 *
 * @property FinGeneralLedger[] $finGeneralLedgers
 * @property User $user
 */
class Payment extends \common\components\MyActiveRecord
{

    const TYPE_CHARGE = 1;
    const TYPE_EXPENSE = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fin_payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'utime', 'uid', 'ctime', 'cid', 'type'], 'integer'],
            [['amount'], 'number'],
            [['order_no'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '消费ID',
            'user_id' => '用户ID',
            'order_no' => '订单号',
            'amount' => '金额',
            'type' => '1: 充值, 2: 消费, 3: 提现',
            'desc' => '说明',
            'status' => 'Status',
            'utime' => 'Utime',
            'uid' => 'Uid',
            'ctime' => 'Ctime',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinGeneralLedgers()
    {
        return $this->hasMany(FinGeneralLedger::className(), ['payment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
