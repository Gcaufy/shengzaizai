<?php

namespace backend\modules\system\models;

use Yii;

/**
 * This is the model class for table "{{%system_region}}".
 *
 * @property string $id
 * @property string $name
 * @property string $longitude
 * @property string $latitude
 * @property string $parent_id
 * @property string $level
 * @property string $isleaf
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property Region $parent
 * @property Region[] $regions
 */
class Region extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%system_region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'longitude', 'latitude'], 'required'],
            [['parent_id', 'level', 'isleaf', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['longitude', 'latitude'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['name'] = '地区名';
        $arr['longitude'] = '经度';
        $arr['latitude'] = '纬度';
        $arr['parent_id'] = '上级';
        $arr['level'] = '层级';
        $arr['isleaf'] = '是否是子节点';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent() {
        return $this->hasOne(Region::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren() {
        return $this->hasMany(Region::className(), ['parent_id' => 'id'])
            ->from(Region::tableName() . ' children');
    }
}
