<?php

namespace backend\modules\doctor\models;

use Yii;

/**
 * This is the model class for table "{{%doctor_opera_map}}".
 *
 * @property string $id
 * @property string $doctor_id
 * @property string $opera_id
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property Doctor $doctor
 * @property Operation $opera
 */
class DoctorOperaMap extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%doctor_opera_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doctor_id', 'opera_id'], 'required'],
            [['doctor_id', 'opera_id', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => '医生ID',
            'opera_id' => '手术ID',
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
    public function getOpera()
    {
        return $this->hasOne(Operation::className(), ['id' => 'opera_id']);
    }
}
