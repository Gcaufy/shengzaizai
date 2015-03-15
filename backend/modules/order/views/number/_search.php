<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\NumberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="number-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'hosp_id') ?>

    <?= $form->field($model, 'opera_id') ?>

    <?= $form->field($model, 'insp_id') ?>

    <?= $form->field($model, 'doctor_id') ?>

    <?php // echo $form->field($model, 'order_num') ?>

    <?php // echo $form->field($model, 'active_order_num') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'cost') ?>

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
