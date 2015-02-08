<?php

use yii\helpers\Html;
use backend\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\doctor\models\DoctorTitle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doctor-title-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
