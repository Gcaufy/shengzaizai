<?php

namespace backend\modules\hospital\models;

use Yii;

/**
 * This is the model class for table "{{%hospital}}".
 *
 * @property string $id
 * @property string $name
 * @property string $addr
 * @property string $tel
 * @property string $region_id
 * @property string $longitude
 * @property string $latitude
 * @property string $opened_order
 * @property string $active_opened_order
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property SystemRegion $region
 * @property InspHospMap[] $inspHospMaps
 * @property OperaHospMap[] $operaHospMaps
 */
class Hospital extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%hospital}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['region_id', 'opened_order', 'active_opened_order', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['addr'], 'string', 'max' => 200],
            [['tel', 'longitude', 'latitude'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['name'] = '医院名';
        $arr['addr'] = '地址';
        $arr['tel'] = '电话';
        $arr['region_id'] = '地区ID';
        $arr['longitude'] = '经度';
        $arr['latitude'] = '纬度';
        $arr['opened_order'] = '预约号';
        $arr['active_opened_order'] = '可用预约号';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion() {
        return $this->hasOne(SystemRegion::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInspHospMaps() {
        return $this->hasMany(InspHospMap::className(), ['hosp_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperaHospMaps() {
        return $this->hasMany(OperaHospMap::className(), ['hosp_id' => 'id']);
    }
}
