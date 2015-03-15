<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\inspection\models\Inspection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inspection-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => 2000]) ?>

    <?= $form->field($model, 'parent_id')->ajaxSelect(Url::to('parentsearch'), ['options' => ['placeholder' => '请选择父级']]) ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
