<?php

namespace api\models;

use Yii;

class Article extends \backend\modules\cms\models\Article {

    use ApiModelTrait;

    public function init () {
        parent::init();
        $url = 'http:' . Yii::$app->urlManager->baseUrl;
        if ($this->url)
            $this->url = $url . '/' . $this->url;

        $this->urlGenerator = ['thumb' => '160x160', 'banner' => '640x300'];
    }

}
