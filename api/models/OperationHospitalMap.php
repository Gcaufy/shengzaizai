<?php

namespace api\models;

use Yii;

class OperationHospitalMap extends \backend\modules\operation\models\OperationHospitalMap {

    use ApiModelTrait;

    public function fields() {
        $fields = $this->initFields();
        unset($fields['id'], $fields['opera_id'], $fields['hosp_id'], $fields['isleaf'], $fields['feedback_number'], $fields['feedback_manner_total'], $fields['feedback_effect_total']);
        return $fields;
    }

}
