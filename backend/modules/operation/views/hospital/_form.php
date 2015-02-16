<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use kartik\rating\StarRating;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\operation\models\OperationHospitalMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-hospital-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hosp_id')->ajaxSelect(Url::to('hospsearch')) ?>

    <?= $form->field($model, 'opera_id')->ajaxSelect(Url::to('operasearch')) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'feedback_score')->widget(StarRating::classname(), [
        'pluginOptions' => ['step' => 1, 'showCaption' => false, 'showClear' => false, 'size' => 'xs', 'hoverEnabled' => 'false']
    ]); ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
