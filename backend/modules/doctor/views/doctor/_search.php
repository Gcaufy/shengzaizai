<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\doctor\models\DoctorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doctor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'hosp_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'desc') ?>

    <?= $form->field($model, 'feedback_manner') ?>
    <?= $form->field($model, 'feedback_effect') ?>

    <?php // echo $form->field($model, 'normal_reg_cost') ?>

    <?php // echo $form->field($model, 'expert_reg_cost') ?>

    <?php // echo $form->field($model, 'order_num') ?>

    <?php // echo $form->field($model, 'active_order_num') ?>

    <?php // echo $form->field($model, 'major') ?>

    <?php // echo $form->field($model, 'experience') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'isvip') ?>

    <?php // echo $form->field($model, 'type') ?>

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
