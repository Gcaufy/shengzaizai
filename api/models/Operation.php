<?php

namespace api\models;

use Yii;

class Operation extends \backend\modules\operation\models\Operation {

    use ApiModelTrait;

    public function getDetail() {
        return $this->hasOne(OperationHospitalMap::className(), ['opera_id' => 'id'])
            ->from(OperationHospitalMap::tableName() . ' detail');
    }
}
