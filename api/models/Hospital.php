<?php

namespace api\models;

use Yii;

class Hospital extends \backend\modules\hospital\models\Hospital {

    public function attributes() {
        $attr = parent::attributes();
        $attr[] = 'distance';
        return $attr;
    }

}
