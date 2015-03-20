<?php

namespace backend\modules\inspection\models;

use Yii;

/**
 * This is the model class for table "{{%inspection}}".
 *
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property string $parent_id
 * @property string $level
 * @property integer $isleaf
 * @property integer $status
 * @property string $utime
 * @property string $uid
 * @property string $ctime
 * @property string $cid
 *
 * @property InspHospMap[] $inspHospMaps
 * @property Inspection $parent
 * @property Inspection[] $inspections
 */
class Inspection extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%inspection}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['parent_id', 'level', 'isleaf', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['desc'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['name'] = '检查名';
        $arr['desc'] = '描述';
        $arr['parent_id'] = '父级';
        $arr['level'] = '层级';
        $arr['isleaf'] = '是否是子节点';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInspHospMaps($hosp_id = null) {
        $relation = $this->hasMany(InspectionHospitalMap::className(), ['insp_id' => 'id'])
            ->from(InspectionHospitalMap::tableName() . ' inspHospMaps');
        if ($hosp_id)
            $relation = $relation->onCondition(['hosp_id' => $hosp_id]);
        return $relation;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent() {
        return $this->hasOne(Inspection::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInspections() {
        return $this->hasMany(Inspection::className(), ['parent_id' => 'id']);
    }
}
