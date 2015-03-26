<?php

namespace backend\modules\operation\models;

use Yii;

/**
 * This is the model class for table "{{%opera_hosp_map}}".
 *
 * @property string $id
 * @property string $hosp_id
 * @property string $opera_id
 * @property string $contact
 * @property integer $feedback_manner
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property Operation $opera
 * @property Hospital $hosp
 */
class OperationHospitalMap extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%opera_hosp_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['hosp_id', 'opera_id', 'contact'], 'required'],
            [['hosp_id', 'opera_id', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
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
        $arr['hosp_id'] = '医院ID';
        $arr['opera_id'] = '手术ID';
        $arr['contact'] = '联系方式';
        $arr['cost'] = '费用';
        $arr['feedback_manner'] = '态度评分';
        $arr['feedback_effect'] = '效果评分';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpera() {
        return $this->hasOne(Operation::className(), ['id' => 'opera_id'])
            ->from(Operation::tableName() . ' opera');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHosp() {
        return $this->hasOne(Hospital::className(), ['id' => 'hosp_id'])
            ->from(Hospital::tableName() . ' hosp');
    }
}
