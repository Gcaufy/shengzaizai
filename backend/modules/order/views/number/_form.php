<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\helpers\Url;
use backend\modules\order\models\Order;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\Number */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="number-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hosp_id')->ajaxSelect(Url::to('hospsearch'), ['options' => ['placeholder' => '请选择医院', 'disabled' => 'disabled']]) ?>

    <?php if($ptype == Order::TYPE_OPERATION): ?>
        <?= $form->field($model, 'opera_id')->ajaxSelect(Url::to('operasearch'), ['options' => ['placeholder' => '请选择手术', 'disabled' => 'disabled']]) ?>
    <?php elseif($ptype == Order::TYPE_INSPECTION): ?>
        <?= $form->field($model, 'insp_id')->ajaxSelect(Url::to('inspsearch'), ['options' => ['placeholder' => '请选择检查', 'disabled' => 'disabled']]) ?>
    <?php elseif($ptype == Order::TYPE_DOCTOR): ?>
        <?= $form->field($model, 'doctor_id')->ajaxSelect(Url::to('doctorsearch'), ['options' => ['placeholder' => '请选择医生', 'disabled' => 'disabled']]) ?>
    <?php endif;?>

    <?= $form->field($model, 'order_num')->textInput(['maxlength' => 11]) ?>


    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => '请选择一个日期'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose'=>true,
        ]
    ]); ?>

    <?= $form->field($model, 'start_time')->widget(TimePicker::classname(), [
        'options' => [
            'readonly' => true,
        ],
        'pluginOptions' => ['defaultTime' => false, 'showMeridian' => false],
    ]); ?>
    <?= $form->field($model, 'end_time')->widget(TimePicker::classname(), [
        'options' => [
            'readonly' => true,
        ],
        'pluginOptions' => ['defaultTime' => false, 'showMeridian' => false],
    ]); ?>

    <?= $form->field($model, 'cost')->textInput(['maxlength' => 10]) ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
