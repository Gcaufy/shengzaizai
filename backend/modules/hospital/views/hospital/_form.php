<?php

use yii\helpers\Html;
use backend\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\hospital\models\Hospital */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hospital-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'addr')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'region_id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'opened_order')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'active_opened_order')->textInput(['maxlength' => 10]) ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
