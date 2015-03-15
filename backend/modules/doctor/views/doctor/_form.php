<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use kartik\rating\StarRating;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\doctor\models\Doctor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doctor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hosp_id')->ajaxSelect(Url::to('hospsearch'), ['options' => ['placeholder' => '请选择医院', 'value' => '0']]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => 2000]) ?>

    <?= $form->field($model, 'feedback_score')->widget(StarRating::classname(), [
        'pluginOptions' => ['step' => 1, 'showCaption' => false, 'showClear' => false, 'size' => 'xs', 'hoverEnabled' => 'false']
    ]); ?>

    <?= $form->field($model, 'normal_reg_cost')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'expert_reg_cost')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'order_num')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'active_order_num')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'major')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'experience')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'isvip')->checkbox() ?>

    <?= $form->field($model, 'type')->radioList(['0' => '可预约医生', '1' => '手术主治医生']) ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
