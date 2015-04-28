<?php

namespace api\models;

use Yii;
use yii\helpers\ArrayHelper;
use \backend\modules\doctor\models\DoctorTag;
use \backend\modules\doctor\models\DoctorTitle;

class Doctor extends \backend\modules\doctor\models\Doctor {

    use ApiModelTrait;


    public function init () {
        parent::init();
        $this->urlGenerator = ['portrait' => '160x160'];
    }

    public function fields() {
        $denied = [];
        if ($this->type == 0) {
            $denied = ['operas'];
        }
        $this->deniedFields = ArrayHelper::merge($this->deniedFields, $denied);
        $fields = $this->initFields();
        $fields['hospital_name'] = 'hospital_name';
        return $fields;
    }

    public function getHospital_name() {
        return $this->hospital->name;
    }

    public function getTag() {
        return $this->hasMany(DoctorTagMap::className(), ['doctor_id' => 'id'])
            ->from(DoctorTagMap::tableName() . ' doctorTagMap');
    }

    public function getTitle() {
        return $this->hasMany(DoctorTitleMap::className(), ['doctor_id' => 'id'])
            ->from(DoctorTitleMap::tableName() . ' doctorTitleMap');
    }

    public function getHospital() {
        return $this->hasOne(Hospital::className(), ['id' => 'hosp_id'])
            ->from(Hospital::tableName() . ' hospital');
    }

}


class DoctorTagMap extends \backend\modules\doctor\models\DoctorTagMap {
    use ApiModelTrait;

    public function fields() {
        $fields = $this->initFields();
        $fields['name'] = 'name';
        unset($fields['id'], $fields['doctor_id']);
        return $fields;
    }

}

class DoctorTitleMap extends \backend\modules\doctor\models\DoctorTitleMap {
    use ApiModelTrait;

    public function fields() {
        $fields = $this->initFields();
        $fields['name'] = 'name';
        unset($fields['id'], $fields['doctor_id']);
        return $fields;
    }
}