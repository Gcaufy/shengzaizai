<?php

namespace api\models;

use Yii;

class InspectionHospitalMap extends \backend\modules\inspection\models\InspectionHospitalMap {

    use ApiModelTrait;

    public function fields() {
        $fields = $this->initFields();
        unset($fields['id'], $fields['insp_id'], $fields['hosp_id'], $fields['isleaf'], $fields['feedback_number'], $fields['feedback_manner_total'], $fields['feedback_effect_total']);
        return $fields;
    }

}
