<?php

namespace api\models;

use Yii;
use \backend\modules\doctor\models\DoctorTag;
use \backend\modules\doctor\models\DoctorTitle;

class Doctor extends \backend\modules\doctor\models\Doctor {

    use ApiModelTrait;

    public function init () {
        parent::init();
        $this->urlGenerator = ['portrait' => '160x160'];
    }

    public function getTag() {
        return $this->hasMany(DoctorTagMap::className(), ['doctor_id' => 'id'])
            ->from(DoctorTagMap::tableName() . ' doctorTagMap');
    }

    public function getTitle() {
        return $this->hasMany(DoctorTitleMap::className(), ['doctor_id' => 'id'])
            ->from(DoctorTitleMap::tableName() . ' doctorTitleMap');
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