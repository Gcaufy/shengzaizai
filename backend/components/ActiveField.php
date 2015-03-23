<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components;
use yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\widgets\Select2;

class ActiveField extends \kartik\form\ActiveField
{
	public $template = "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>";
	public $labelOptions = ['class' => 'col-sm-2 col-sm-2 control-label'];


	public function ajaxSelect($url, $options = [])
    {
$initScript = <<< SCRIPT
function (element, callback) {
    var id=\$(element).val();
    if (id !== "") {
        \$.ajax("{$url}?id=" + id, {
            dataType: "json"
        }).done(function(data) {
        	callback(data.results);
        });
    }
}
SCRIPT;

        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $model = $this->model;
        $attribute = $this->attribute;
        $options = array_merge([
	        'name' => Html::getInputName($model, $attribute),
	        'value' => $model->$attribute,
	        'language' => Yii::$app->language,
	        'options' => ['id' => 'ddl_' . Html::getInputId($model, $attribute), 'placeholder' => '请选择'],
	        //'addon' => ['prepend' => ['content' => '<i class="fa fa-cc"></i>']],
	        'pluginOptions' => [
	            'allowClear' => true,
	            //'multiple' => true,
	            'closeOnSelect' => false,
	            'ajax' => [
	                'url' => $url,
	                'dataType' => 'json',
	                'data' => new JsExpression('function(term, page) { return { search: term }; }'),
	                'results' => new JsExpression('function(data, page) { return { results: data.results }; }'),
	            ],
	            'initSelection' => new JsExpression($initScript),
	        ],
	    ], $options);
        $this->parts['{input}'] = Select2::widget($options);

       	return $this;
    }


    public function initLen($n) {
        $this->options['class'] .= ' col-md-' . $n;
        return $this;
    }
}