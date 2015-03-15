<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\helpers\Url;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model backend\modules\inspection\models\InspectionHospitalMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inspection-hospital-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'insp_id')->ajaxSelect(Url::to('inspsearch'), ['options' => ['placeholder' => '请选择父级']]) ?>

    <?= $form->field($model, 'hosp_id')->ajaxSelect(Url::to('hospsearch'), ['options' => ['placeholder' => '请选择父级']]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'feedback_score')->widget(StarRating::classname(), [
        'pluginOptions' => ['step' => 1, 'showCaption' => false, 'showClear' => false, 'size' => 'xs', 'hoverEnabled' => 'false']
    ]); ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
