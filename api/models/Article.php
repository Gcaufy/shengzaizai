<?php

namespace api\models;

use Yii;

class Article extends \backend\modules\cms\models\Article {

    public function init () {
        parent::init();
        $url = 'http:' . Yii::$app->urlManager->baseUrl;
        if ($this->url)
            $this->url = $url . '/' . $this->url;
    }

    public function fields() {
        $fields = parent::fields();
        if ($this->thumb)
            $fields['thumb_url'] = 'thumb_url';
        if ($this->banner && $this->isbanner)
            $fields['banner_url'] = 'banner_url';
        return $fields;
    }

    public function getThumb_url() {
        return 'http:' . Yii::$app->urlManager->baseUrl . '/file?thumb=160x160&id=' . $this->thumb;
    }

    public function getBanner_url() {
        return 'http:' . Yii::$app->urlManager->baseUrl . '/file?thumb=640x300&id=' . $this->banner;
    }
}
