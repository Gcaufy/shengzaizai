<?php
namespace backend\components;

use Yii;
use yii\helpers\Url;
use common\models\User;

class ActionColumn extends \yii\grid\ActionColumn {
	
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            if (isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
        		if (User::checkAction($url))
                	return call_user_func($this->buttons[$name], $url, $model, $key);
            } else {
                return '';
            }
        }, $this->template);
    }
}