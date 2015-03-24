<?php

namespace api\models;

use Yii;

class OrderOpen extends \backend\modules\order\models\Number {

    use ApiModelTrait;

    public function fields() {
        $fields = $this->initFields();
        if (Yii::$app->request->get('doctor_id')) {
            unset($fields['insp_id'], $fields['opera_id']);
        }
        if (Yii::$app->request->get('insp_id')) {
            unset($fields['doctor_id'], $fields['opera_id'], $fields['type']);
        }
        if (Yii::$app->request->get('opera_id')) {
            unset($fields['insp_id'], $fields['doctor_id'], $fields['type']);
        }
        return $fields;
    }
}
