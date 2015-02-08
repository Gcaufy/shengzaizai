<?php

namespace backend\modules\doctor\models;

use Yii;

/**
 * This is the model class for table "{{%doctor_tag}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property DoctorTagMap[] $doctorTagMaps
 */
class DoctorTag extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%doctor_tag}}';
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
        $arr['name'] = '标签名';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctorTagMaps() {
        return $this->hasMany(DoctorTagMap::className(), ['tag_id' => 'id']);
    }
}
