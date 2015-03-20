<?php

namespace backend\modules\doctor\models;

use Yii;
use \backend\modules\hospital\models\Hospital;

/**
 * This is the model class for table "{{%doctor}}".
 *
 * @property string $id
 * @property string $hosp_id
 * @property string $name
 * @property string $desc
 * @property string $feedback_score
 * @property string $normal_reg_cost
 * @property string $expert_reg_cost
 * @property string $order_num
 * @property string $active_order_num
 * @property string $major
 * @property string $experience
 * @property string $note
 * @property integer $isvip
 * @property integer $type
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property DoctorTagMap[] $doctorTagMaps
 * @property DoctorTitleMap[] $doctorTitleMaps
 */
class Doctor extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%doctor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['hosp_id', 'name'], 'required'],
            [['hosp_id', 'feedback_score', 'order_num', 'active_order_num', 'isvip', 'type', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['normal_reg_cost', 'expert_reg_cost'], 'number'],
            [['name'], 'string', 'max' => 20],
            [['desc'], 'string', 'max' => 2000],
            [['major', 'experience', 'note'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['hosp_id'] = '医院';
        $arr['name'] = '医生名';
        $arr['desc'] = '描述';
        $arr['feedback_score'] = '评分';
        $arr['normal_reg_cost'] = '普通挂号费';
        $arr['expert_reg_cost'] = '专家挂号费';
        $arr['order_num'] = '预约号';
        $arr['active_order_num'] = '可用预约号';
        $arr['major'] = '主要擅长';
        $arr['experience'] = '从业经验';
        $arr['note'] = '医生贴士';
        $arr['isvip'] = '是否为特约';
        $arr['type'] = '类型';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctorTagMap() {
        return $this->hasMany(DoctorTagMap::className(), ['doctor_id' => 'id'])
            ->from(DoctorTagMap::tableName() . ' doctorTagMap');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctorTitleMap() {
        return $this->hasMany(DoctorTitleMap::className(), ['doctor_id' => 'id'])
            ->from(DoctorTitleMap::tableName() . ' doctorTitleMap');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospital() {
        return $this->hasOne(Hospital::className(), ['id' => 'hosp_id'])
            ->from(Hospital::tableName() . ' hospital');
    }
}
