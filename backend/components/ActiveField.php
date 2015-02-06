<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class ActiveField extends \yii\widgets\ActiveField
{
	public $template = "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>";
	public $labelOptions = ['class' => 'col-sm-2 col-sm-2 control-label'];
}