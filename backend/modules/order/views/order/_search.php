<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_no') ?>

    <?= $form->field($model, 'hosp_id') ?>

    <?= $form->field($model, 'opera_id') ?>

    <?= $form->field($model, 'opera_name') ?>

    <?php // echo $form->field($model, 'insp_id') ?>

    <?php // echo $form->field($model, 'insp_name') ?>

    <?php // echo $form->field($model, 'doctor_id') ?>

    <?php // echo $form->field($model, 'doctor_job_title') ?>

    <?php // echo $form->field($model, 'doctor_name') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'payment_method') ?>

    <?php // echo $form->field($model, 'payment_id') ?>

    <?php // echo $form->field($model, 'refund_id') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'process') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'utime') ?>

    <?php // echo $form->field($model, 'uid') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <?php // echo $form->field($model, 'cid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
