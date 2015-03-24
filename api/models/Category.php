<?php

namespace api\models;

use Yii;

class Category extends \backend\modules\cms\models\Category {

    use ApiModelTrait;

    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id'])
            ->from(Article::tableName() . ' articles10')->limit(10);
    }
}
