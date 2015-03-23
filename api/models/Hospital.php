<?php

namespace api\models;

use Yii;

class Hospital extends \backend\modules\hospital\models\Hospital {

    public function attributes() {
        $attr = parent::attributes();
        $attr[] = 'distance';
        return $attr;
    }

    public function fields() {
        $fields = parent::fields();
        if ($this->pic)
            $fields['pic_url'] = 'pic_url';
        return $fields;
    }

    public function getPic_url() {
        return 'http:' . Yii::$app->urlManager->baseUrl . '/file?thumb=160x160&id=' . $this->pic;
    }

}
