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
 * @property integer $feedback_score
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
            [['hosp_id', 'opera_id', 'contact', 'feedback_score'], 'required'],
            [['hosp_id', 'opera_id', 'feedback_score', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['contact'], 'string', 'max' => 50]
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
        $arr['feedback_score'] = '反馈评分';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpera() {
        return $this->hasOne(Operation::className(), ['id' => 'opera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHosp() {
        return $this->hasOne(Hospital::className(), ['id' => 'hosp_id']);
    }
}
