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

class ActiveForm extends \kartik\form\ActiveForm
{
    public $type = self::TYPE_HORIZONTAL;

    public $fieldClass = 'backend\components\ActiveField';

    public function init() {
        if (!isset($this->fieldConfig['class'])) {
            $this->fieldConfig['class'] = $this->fieldClass;
        }
        parent::init();
    }
}
