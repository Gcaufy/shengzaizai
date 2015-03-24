<?php

namespace backend\modules\doctor\models;

use Yii;

/**
 * This is the model class for table "{{%doctor_tag_map}}".
 *
 * @property string $id
 * @property string $doctor_id
 * @property string $tag_id
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property Doctor $doctor
 * @property DoctorTag $tag
 */
class DoctorTagMap extends \common\components\MyActiveRecord
 {
    public $name;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%doctor_tag_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['doctor_id', 'tag_id'], 'required'],
            [['doctor_id', 'tag_id', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['doctor_id'] = '医生ID';
        $arr['tag_id'] = '标签ID';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor() {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id'])
            ->from(Doctor::tableName() . ' doctor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag() {
        return $this->hasOne(DoctorTag::className(), ['id' => 'tag_id'])
            ->from(DoctorTag::tableName() . ' tag');
    }
}
