<?php

namespace backend\modules\order\models;

use Yii;

/**
 * This is the model class for table "{{%order_number}}".
 *
 * @property string $id
 * @property string $hosp_id
 * @property string $opera_id
 * @property string $insp_id
 * @property string $doctor_id
 * @property string $order_num
 * @property string $active_order_num
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property integer $type
 * @property string $cost
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 *
 * @property Doctor $doctor
 * @property Hospital $hosp
 * @property Inspection $insp
 * @property Operation $opera
 */
class Number extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_number}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hosp_id', 'opera_id', 'insp_id', 'doctor_id', 'order_num', 'active_order_num', 'type', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['date', 'start_time', 'end_time'], 'safe'],
            [['cost'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hosp_id' => '医院ID',
            'opera_id' => '手术ID',
            'insp_id' => '检查ID',
            'doctor_id' => '医生ID',
            'order_num' => '预约号数量',
            'active_order_num' => '可用预约号',
            'date' => '日期',
            'start_time' => '起始时间',
            'end_time' => '结束时间',
            'type' => '预约类型',
            'cost' => '预约价格',
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
