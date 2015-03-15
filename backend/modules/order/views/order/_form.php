<?php

use yii\helpers\Html;
use backend\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'order_no')->textInput(['maxlength' => 12]) ?>

    <?= $form->field($model, 'hosp_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'opera_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'opera_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'insp_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'insp_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'doctor_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'doctor_job_title')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'doctor_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'payment_method')->textInput() ?>

    <?= $form->field($model, 'payment_id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'refund_id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'cost')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'process')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'utime')->textInput() ?>

    <?= $form->field($model, 'uid')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <?= $form->field($model, 'cid')->textInput(['maxlength' => 10]) ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
