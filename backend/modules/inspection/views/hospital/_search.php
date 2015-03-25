<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\inspection\models\InspectionHospitalMapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inspection-hospital-map-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'insp_id') ?>

    <?= $form->field($model, 'hosp_id') ?>

    <?= $form->field($model, 'contact') ?>


    <?php // echo $form->field($model, 'isleaf') ?>

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
