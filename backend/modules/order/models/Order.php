<?php

namespace backend\modules\order\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $order_no
 * @property string $hosp_id
 * @property string $opera_id
 * @property string $opera_name
 * @property string $insp_id
 * @property string $insp_name
 * @property string $doctor_id
 * @property string $doctor_job_title
 * @property string $doctor_name
 * @property string $address
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property integer $type
 * @property integer $payment_method
 * @property string $payment_id
 * @property string $refund_id
 * @property string $cost
 * @property integer $process
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 *
 * @property FinPayment $payment
 * @property Doctor $doctor
 * @property Hospital $hosp
 * @property Inspection $insp
 * @property Operation $opera
 */
class Order extends \common\components\MyActiveRecord
{

    const TYPE_OPERATION = 1;
    const TYPE_INSPECTION = 2;
    const TYPE_DOCTOR = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    public static function getTypeMap() {
        return [
            self::TYPE_OPERATION => '手术',
            self::TYPE_INSPECTION => '检查',
            self::TYPE_DOCTOR => '医生',
        ];
    }
    public static function getTypeKeyMap() {
        return [
            self::TYPE_OPERATION => 'opera_id',
            self::TYPE_INSPECTION => 'insp_id',
            self::TYPE_DOCTOR => 'doctor_id',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_no'], 'required'],
            [['id', 'hosp_id', 'opera_id', 'insp_id', 'doctor_id', 'type', 'payment_method', 'payment_id', 'refund_id', 'process', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['date', 'start_time', 'end_time'], 'safe'],
            [['cost'], 'number'],
            [['order_no'], 'string', 'max' => 12],
            [['opera_name', 'insp_name', 'doctor_job_title', 'doctor_name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => '订单号',
            'hosp_id' => '医院ID',
            'opera_id' => '手术ID',
            'opera_name' => '手术名称',
            'insp_id' => '检查ID',
            'insp_name' => '检查名称',
            'doctor_id' => '医生ID',
            'doctor_job_title' => '医生职称',
            'doctor_name' => '医生姓名',
            'address' => '预约地址',
            'date' => '日期',
            'start_time' => '起始时间',
            'end_time' => '结束时间',
            'type' => '预约类型',
            'payment_method' => '付款方式',
            'payment_id' => '付款ID',
            'refund_id' => '退款ID',
            'cost' => '价格',
            'process' => '状态',
            'status' => '状态',
            'utime' => '修改时间',
            'uid' => '修改人',
            'ctime' => '创建时间',
            'cid' => '创建人',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(FinPayment::className(), ['id' => 'payment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHosp()
    {
        return $this->hasOne(Hospital::className(), ['id' => 'hosp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsp()
    {
        return $this->hasOne(Inspection::className(), ['id' => 'insp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpera()
    {
        return $this->hasOne(Operation::className(), ['id' => 'opera_id']);
    }
}
