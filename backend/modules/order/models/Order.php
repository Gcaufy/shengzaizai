<?php

namespace backend\modules\order\models;

use Yii;
use backend\modules\hospital\models\Hospital;
use backend\modules\doctor\models\Doctor;
use backend\modules\inspection\models\Inspection;
use backend\modules\operation\models\Operation;
use \common\models\User;

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

    public $puser;
    public $pordername;

    const TYPE_OPERATION = 1;
    const TYPE_INSPECTION = 2;
    const TYPE_DOCTOR = 3;

    const PROCESS_NEW = 0;
    const PROCESS_DONE = 1;
    const PROCESS_CANCEL = 2;
    const PROCESS_DUE = 3;
    /**
     * @inheritdoc
     */

    public function init() {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'evtGeneratOrderNo']);
    }

    public function evtGeneratOrderNo($evt) {
        $model = $evt->sender;
        $evt->isValid = true;
        $model->generateOrderNo();
    }


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
    public static function getProcessMap() {
        return [
            self::PROCESS_NEW => '新订单',
            self::PROCESS_DONE => '已完成',
            self::PROCESS_CANCEL => '被取消',
            self::PROCESS_DUE => '已过期',
        ];
    }

    public function getProcessDesc() {
        return self::getProcessMap()[$this->process];
    }
    public function getTypeDesc() {
        return self::getTypeMap()[$this->type];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openorder_id'], 'required'],
            [['id', 'hosp_id', 'opera_id', 'insp_id', 'doctor_id', 'type', 'payment_method', 'payment_id', 'refund_id', 'process', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['date', 'start_time', 'end_time'], 'safe'],
            [['cost'], 'number'],
            [['order_no'], 'string', 'max' => 12],
            [['opera_name', 'insp_name', 'doctor_job_title', 'doctor_name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 200],
            [['instruction'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'puser' => '姓名',
            'pordername' => '预约',
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
            'instruction' => '医嘱',
            'process' => '状态',
            'status' => '状态',
            'utime' => '修改时间',
            'uid' => '修改人',
            'ctime' => '创建时间',
            'cid' => '创建人',
        ];
    }

    public function generateOrderNo() {
        // 18
        $timestr = date("YmdHis") . str_pad(floor(microtime()*1000), 4, '0', STR_PAD_LEFT);
        // 3
        $rand = mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
        // 1
        $orderno = $timestr . $rand . $this->type;
        if(static::find()->andWhere(['order_no' => $orderno])->one()) {
            return self::generateOrderNo();
        }
        $this->order_no = $orderno;
        return $orderno;
    }

    public function checkExist($openorderId) {
        return static::find()->andWhere(['t.openorder_id' => $openorderId])->one();
    }

    public function loadOrder($openOrder) {
        $this->openorder_id = $openOrder->id;
        $this->hosp_id = $openOrder->hosp_id;
        $this->doctor_id = $openOrder->doctor_id;
        $this->insp_id = $openOrder->insp_id;
        $this->opera_id = $openOrder->opera_id;
        $this->date = $openOrder->date;
        $this->start_time = $openOrder->start_time;
        $this->end_time = $openOrder->end_time;
        $this->isvip = $openOrder->isvip;
        $this->cost = $openOrder->cost;
        if ($this->insp_id)
            $this->type = Order::TYPE_INSPECTION;
        else if ($this->opera_id)
            $this->type = Order::TYPE_OPERATION;
        else if ($this->doctor_id)
            $this->type = Order::TYPE_DOCTOR;
        return $this->fillDups();
    }

    public function fillDups() {
        if ($this->hosp_id) {
            $hosp = Hospital::find()->andWhere(['t.id' => $this->hosp_id])->asArray()->one();
            if (!$hosp)
                return false;
            $this->address = $hosp['addr'];
        }
        if ($this->doctor_id) {
            $doctor = Doctor::find()->joinWith('title.title')->andWhere(['t.id' => $this->doctor_id])->asArray()->one();
            if (!$doctor)
                return false;
            $this->doctor_name = $doctor['name'];
            $titles = $doctor['title'];
            $str = '';
            foreach ($titles as $title) {
                $str .= (isset($title['title']) && is_array($title['title'])) ? ($title['title']['name'] . ' / ') : '';
            }
            if ($str)
                $this->doctor_job_title = substr($str, 0, strlen($str) - 3);
        }
        if ($this->insp_id) {
            $insp = Inspection::find()->andWhere(['t.id' => $this->insp_id])->asArray()->one();
            if (!$insp)
                return false;
            $this->insp_name = $insp['name'];
        }
        if ($this->opera_id) {
            $opera = Operation::find()->andWhere(['t.id' => $this->opera_id])->asArray()->one();
            if (!$opera)
                return false;
            $this->opera_name = $opera['name'];
        }
        return true;
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'cid'])
            ->from(User::tableName() . ' user');
    }
}
