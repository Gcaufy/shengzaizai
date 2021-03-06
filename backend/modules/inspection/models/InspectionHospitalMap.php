<?php

namespace backend\modules\inspection\models;

use Yii;

/**
 * This is the model class for table "{{%insp_hosp_map}}".
 *
 * @property string $id
 * @property string $insp_id
 * @property string $hosp_id
 * @property string $contact
 * @property integer $feedback_manner
 * @property integer $feedback_effect
 * @property integer $isleaf
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property Hospital $hosp
 * @property Inspection $insp
 */
class InspectionHospitalMap extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%insp_hosp_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['insp_id', 'hosp_id', 'isleaf', 'status', 'utime', 'uid', 'ctime', 'cid', 'ordered'], 'integer'],
            [['feedback_manner', 'feedback_effect'], 'number'],
            [['contact'], 'string', 'max' => 50],
            [['cost'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['insp_id'] = '检查ID';
        $arr['hosp_id'] = '医院ID';
        $arr['contact'] = '联系方式';
        $arr['cost'] = '费用';
        $arr['ordered'] = '已预约';
        $arr['feedback_manner'] = '态度评分';
        $arr['feedback_effect'] = '效果评分';
        $arr['isleaf'] = '是否是子节点';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHosp() {
        return $this->hasOne(Hospital::className(), ['id' => 'hosp_id'])
            ->from(Hospital::tableName() . ' hosp');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsp() {
        return $this->hasOne(Inspection::className(), ['id' => 'insp_id'])
            ->from(Inspection::tableName() . ' insp');
    }
}
