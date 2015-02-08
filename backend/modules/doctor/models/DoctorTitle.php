<?php

namespace backend\modules\doctor\models;

use Yii;

/**
 * This is the model class for table "{{%doctor_title}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property DoctorTitleMap[] $doctorTitleMaps
 */
class DoctorTitle extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%doctor_title}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['name'] = '职称名';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctorTitleMaps() {
        return $this->hasMany(DoctorTitleMap::className(), ['title_id' => 'id']);
    }
}
