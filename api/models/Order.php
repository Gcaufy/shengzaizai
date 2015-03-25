<?php

namespace api\models;

use Yii;
use yii\helpers\ArrayHelper;

class Order extends \backend\modules\order\models\Order {

    use ApiModelTrait;

    public function fields() {
        $denied = [];
        if ($this->opera_id) {
            $denied = ['isvip', 'insp_id', 'insp_name'];
        } else if ($this->insp_id) {
            $denied = ['doctor_id', 'doctor_name', 'doctor_job_title', 'isvip', 'opera_name', 'opera_id'];
        } else if ($this->doctor_id) {
            $denied = ['insp_id', 'insp_name', 'opera_name', 'opera_id'];
        }
        $this->deniedFields = ArrayHelper::merge($this->deniedFields, $denied);
        $fields = $this->initFields();
        return $fields;
    }
}
