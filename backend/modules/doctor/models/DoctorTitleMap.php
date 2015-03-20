<?php

namespace backend\modules\doctor\models;

use Yii;

/**
 * This is the model class for table "{{%doctor_title_map}}".
 *
 * @property string $id
 * @property string $doctor_id
 * @property string $title_id
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property Doctor $doctor
 * @property DoctorTitle $title
 */
class DoctorTitleMap extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%doctor_title_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['doctor_id', 'title_id'], 'required'],
            [['doctor_id', 'title_id', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['doctor_id'] = '医生ID';
        $arr['title_id'] = '头衔ID';
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
    public function getTitle() {
        return $this->hasOne(DoctorTitle::className(), ['id' => 'title_id'])
            ->from(DoctorTitle::tableName() . ' title');
    }
}
