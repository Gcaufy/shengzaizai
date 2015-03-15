<?php

namespace common\models\finance;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%general_ledger}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $payment_id
 * @property string $order_no
 * @property string $direction
 * @property string $amount
 * @property string $desc
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 *
 * @property User $user
 * @property UserPayment $payment
 */
class GeneralLedger extends \common\components\MyActiveRecord
{
    const DIRECTION_CREDIT = 'C';
    const DIRECTION_DEBIT = 'D';

    public $ptype = '';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fin_general_ledger}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'payment_id', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['direction'], 'string'],
            [['amount'], 'number'],
            [['order_no'], 'string', 'max' => 50],
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
            'payment_id' => '交易ID',
            'order_no' => '订单号',
            'direction' => '类型',
            'amount' => '金额 (元)',
            'type' => '类型',
            'ptype' => '类型',
            'utime' => 'Utime',
            'uid' => 'Uid',
            'ctime' => '时间',
            'cid' => 'Cid',
        ];
    }

    public static function getTypeMap() {
        return [
            self::DIRECTION_DEBIT => '支出',
            self::DIRECTION_CREDIT => '收入',
        ];
    }

    public function getType() {
        $map = GeneralLedger::getTypeMap();
        $this->ptype = $map[$this->direction];
        return $this->ptype;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ['id' => 'payment_id'])
            ->from(Payment::tableName() . ' payment');
    }


    public function search($params)
    {
        $query = self::find()->andWhere(['t.user_id' => Yii::$app->user->identity->id])->joinWith('payment');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            't.direction' => $this->direction,
        ]);


        $query->andFilterWhere(['like', 'order_no', $this->order_no]);

        return $dataProvider;
    }
}
