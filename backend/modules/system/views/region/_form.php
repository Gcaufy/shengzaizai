<?php

use yii\helpers\Html;
use backend\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\system\models\Region */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="region-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => 20]) ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
