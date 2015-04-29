<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\components\ActiveForm;
use kartik\rating\StarRating;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\web\JsExpression;
use backend\modules\doctor\models\DoctorTag;
use backend\modules\doctor\models\DoctorTitle;
use backend\modules\operation\models\Operation;


/* @var $this yii\web\View */
/* @var $model backend\modules\doctor\models\Doctor */
/* @var $form yii\widgets\ActiveForm */
$js = "
$('input[name=file]').on('fileuploaded', function(event, data, previewId, index) {
    var response = data.response;
    if (response && response.result && response.result.length === 1) {
        $('#' + $(this).attr('target')).val(response.result[0]);
    }

});
function operaInit() {
    elem = $('#doctor-type');
    if (!elem.attr('checked')) {
        $('#doctor-opera').hide().find('input').attr('disabled' ,'disabled');
    } else {
        $('#doctor-opera').show().find('input').removeAttr('disabled');
    }
}

$('#doctor-type').change(operaInit);
operaInit();



$('#doctor-isbanner').click(function () {
    if ($(this).attr('checked')) {
        $('#banner-panel').show().find('input').removeAttr('disabled');
    } else {
        $('#banner-panel').hide().find('input').attr('disabled', 'disabled');
    }
});

";
$this->registerJs($js);
?>

<div class="doctor-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => [
            'labelSpan' => ActiveForm::NOT_SET,
            'deviceSize' => ActiveForm::NOT_SET,
            'showLabels' => ActiveForm::SCREEN_READER,
            'showErrors' => false,
            'showHints' => true
        ]
    ]); ?>



    <?= $form->field($model, 'pportrait', ['autoPlaceholder' => true])->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*', 'name' => 'file', 'target' => 'doctor-portrait'],
        'pluginOptions' => [
            'uploadUrl' => Url::to(['/file/upload?folder=doctor']),
            'initialPreview' => $model->portrait ? [Html::img("/file?id=" . $model->portrait, ['class'=>'file-preview-image'])] : [],
            'initialCaption'=>"已保存图片",
        ]
    ])->initLen(4); ?>
    <?= Html::activeHiddenInput($model, 'portrait'); ?>
    <?php
        $option = ['placeholder' => '请选择医院', 'value' => '0'];
        if ($hospital)
            $option['disabled'] = true;
    ?>
    <?= $form->field($model, 'hosp_id', ['autoPlaceholder' => true])->ajaxSelect(Url::to('hospsearch'), ['options' => $option])->initLen(5) ?>

    <?= $form->field($model, 'name', ['autoPlaceholder' => true])->textInput(['maxlength' => 20])->initLen(2)  ?>

    <?= $form->field($model, 'feedback_manner', ['autoPlaceholder' => true])->widget(StarRating::classname(), [
        'pluginOptions' => ['step' => 1, 'showCaption' => false, 'showClear' => false, 'size' => 'xs', 'hoverEnabled' => 'false']
    ])->initLen(2)->hint($model->attributeLabels()['feedback_manner']); ?>
    <?= $form->field($model, 'feedback_effect', ['autoPlaceholder' => true])->widget(StarRating::classname(), [
        'pluginOptions' => ['step' => 1, 'showCaption' => false, 'showClear' => false, 'size' => 'xs', 'hoverEnabled' => 'false']
    ])->initLen(2)->hint($model->attributeLabels()['feedback_effect']);; ?>

    <?= $form->field($model, 'normal_reg_cost', ['autoPlaceholder' => true])->textInput(['maxlength' => 10])->initLen(2) ?>

    <?= $form->field($model, 'expert_reg_cost', ['autoPlaceholder' => true])->textInput(['maxlength' => 10])->initLen(2) ?>

    <?= $form->field($model, 'isvip', ['autoPlaceholder' => true])->checkbox()->initLen(2) ?>

    <?= $form->field($model, 'type', ['autoPlaceholder' => true])->checkbox()->initLen(2) ?>

    <div id="doctor-opera">
    <?= $form->field($model, 'operas', ['autoPlaceholder' => true])->widget(Select2::classname(), [
        'options' => ['placeholder' => '选择手术 ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => ArrayHelper::getColumn(Operation::find()->select('name')->asArray()->all(), 'name'),
            'maximumInputLength' => 10,
        ],
    ])->initLen(6) ?>
    </div>


    <?= $form->field($model, 'tag', ['autoPlaceholder' => true])->widget(Select2::classname(), [
        'options' => ['placeholder' => '选择标签 ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => ArrayHelper::getColumn(DoctorTag::find()->select('name')->asArray()->all(), 'name'),
            'maximumInputLength' => 10,
        ],
    ])->initLen(6) ?>


    <?= $form->field($model, 'title', ['autoPlaceholder' => true])->widget(Select2::classname(), [
        'options' => ['placeholder' => '选择职称 ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => ArrayHelper::getColumn(DoctorTitle::find()->select('name')->asArray()->all(), 'name'),
            // ["red", "green", "blue", "orange", "white", "black", "purple", "cyan", "teal"],
            'maximumInputLength' => 10,
            'separator' => ' / '
        ],
    ])->initLen(6) ?>

    <?= $form->field($model, 'desc', ['autoPlaceholder' => true])->textArea(['maxlength' => 2000]) ?>


    <?= $form->field($model, 'major', ['autoPlaceholder' => true])->textArea(['maxlength' => 500]) ?>

    <?= $form->field($model, 'experience', ['autoPlaceholder' => true])->textArea(['maxlength' => 500]) ?>

    <?= $form->field($model, 'note', ['autoPlaceholder' => true])->textArea(['maxlength' => 500]) ?>

    <?= $form->field($model, 'isbanner')->checkbox([], false)->hint('如果此文章希望在Banner处显示, 则勾选此项.') ?>
    <?php
        $options = [];
        $style = $model->isbanner ? "display: block;" : "display: none;";
        if (!$model->isbanner)
            $options['disabled'] = 'disabled';
    ?>
    <div id="banner-panel" style="<?= $style ?>">
        <?= $form->field($model, 'pbanner')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*', 'name' => 'file', 'target' => 'doctor-banner'],
        'pluginOptions' => [
            'uploadUrl' => Url::to(['/file/upload?folder=banner']),
            'initialPreview' => $model->banner ? [Html::img("/file?id=" . $model->banner, ['class'=>'file-preview-image'])] : [],
            'initialCaption'=>"已保存图片",
        ]
    ]); ?>
        <?= Html::activeHiddenInput($model, 'banner'); ?>
        <?= $form->field($model, 'banner_position', ['autoPlaceholder' => true])->textInput($options) ?>
    </div>


    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
