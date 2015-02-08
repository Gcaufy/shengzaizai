<?php

namespace backend\modules\operation\models;

use Yii;

/**
 * This is the model class for table "{{%operation}}".
 *
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property OperaHospMap[] $operaHospMaps
 */
class Operation extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%operation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['desc'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['name'] = '手术名';
        $arr['desc'] = '描述';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperaHospMaps() {
        return $this->hasMany(OperaHospMap::className(), ['opera_id' => 'id']);
    }
}
