<?php

namespace api\models;

use Yii;

trait ApiModelTrait {

    public $deniedFields = ['status', 'utime', 'ctime', 'uid', 'cid'];

    public $urlGenerator = [];

    public function getPortrait_url() {
        return 'http:' . Yii::$app->urlManager->baseUrl . '/file?thumb=160x160&id=' . $this->portrait;
    }

    public function fields() {
        return $this->initFields();
    }

    public function initFields() {
        $fields = parent::fields();
        $denied = $this->deniedFields;
        foreach ($denied as $value) {
            if(isset($fields[$value]))
                unset($fields[$value]);
        }
        $urls = $this->urlGenerator;
        foreach ($urls as $key => $value) {
            $key .= '_url';
            $fields[$key] = $key;
        }
        return $fields;
    }

    public function __get($name) {
        return $this->initGet($name);
    }

    public function initGet($name) {
        $len = strlen($name);
        if ($len > 4) {
            $last4 = substr($name, $len - 4, 4);
            $first = substr($name, 0, $len - 4);
            if ($last4 === '_url' && array_key_exists($first, $this->urlGenerator)) {
                if ($this->$first)
                    return 'http:' . Yii::$app->urlManager->baseUrl . '/file?thumb=' . $this->urlGenerator[$first] . '&id=' . $this->$first;
                else
                    return null;
            }
        }
        return parent::__get($name);
    }

}
