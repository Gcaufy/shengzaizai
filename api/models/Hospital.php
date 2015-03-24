<?php

namespace api\models;

use Yii;

class Hospital extends \backend\modules\hospital\models\Hospital {

    use ApiModelTrait;

    public function init () {
        parent::init();
        $this->urlGenerator = ['pic' => '160x160'];
    }

    public function attributes() {
        $attr = parent::attributes();
        $attr[] = 'distance';
        return $attr;
    }

}
