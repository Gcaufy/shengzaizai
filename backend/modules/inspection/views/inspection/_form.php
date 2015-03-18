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

    <?php if (Yii::$app->request->isAjax): ?>
        <?php if ($parent): ?>
            <?= $form->field($model, 'parent_id')->textInput(['value' => $parent->name, 'disabled' => true]); ?>
        <?php else: ?>
            <?= $form->field($model, 'parent_id')->textInput(['value' => '顶级项目', 'disabled' => true]); ?>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($parent): ?>
            <?= $form->field($model, 'parent_id')->ajaxSelect(Url::to('parentsearch'), ['options' => ['placeholder' => '请选择父级', 'disabled' => true]]) ?>
        <?php else: ?>
            <?= $form->field($model, 'parent_id')->ajaxSelect(Url::to('parentsearch'), ['options' => ['placeholder' => '请选择父级']]) ?>
        <?php endif; ?>
    <?php endif; ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => 2000]) ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['id' => 'btn_submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
