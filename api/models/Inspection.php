<?php

namespace api\models;

use Yii;

class Inspection extends \backend\modules\inspection\models\Inspection {

    use ApiModelTrait;



    public function getDetail() {
        return $this->hasOne(InspectionHospitalMap::className(), ['insp_id' => 'id'])
            ->from(InspectionHospitalMap::tableName() . ' detail');
    }
}
