<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components;

use Yii;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = 'backend\components\ActiveField';
    
    public function init()
    {
        if (!isset($this->options['class'])) {
            $this->options['class'] = 'form-horizontal adminex-form';
        }
        parent::init();
    }
}
