<?php

use yii\helpers\Html;
use backend\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\inspection\models\InspectionHospitalMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inspection-hospital-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'insp_id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'hosp_id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'feedback_score')->textInput() ?>

    <?= $form->field($model, 'isleaf')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'utime')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'uid')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'ctime')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'cid')->textInput(['maxlength' => 10]) ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
