<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\operation\models\OperationHospitalMapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-hospital-map-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'hosp_id') ?>

    <?= $form->field($model, 'opera_id') ?>

    <?= $form->field($model, 'contact') ?>


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
