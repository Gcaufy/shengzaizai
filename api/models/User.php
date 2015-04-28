<?php

namespace api\models;

use Yii;

class User extends \common\models\User {

    use ApiModelTrait;

    public function init () {
        parent::init();
        $this->urlGenerator = ['portrait' => '138x138'];
        $this->deniedFields[] = 'auth_key';
        $this->deniedFields[] = 'password';
        $this->deniedFields[] = 'payment_password';
        $this->deniedFields[] = 'role';
    }
    public function fields() {
        $fields = $this->initFields();
        $fields['status'] = 'status';
        return $fields;
    }
}
