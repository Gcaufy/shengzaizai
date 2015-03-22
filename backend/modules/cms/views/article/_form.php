<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\helpers\ArrayHelper;
use Zelenin\yii\widgets\Summernote\Summernote;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\Article */
/* @var $form yii\widgets\ActiveForm */
$js = "
$('input[name=file]').on('fileuploaded', function(event, data, previewId, index) {
    var response = data.response;
    if (response && response.result && response.result.length === 1) {
        $('#' + $(this).attr('target')).val(response.result[0]);
    }
});
$('#article-isbanner').click(function () {
    if ($(this).attr('checked')) {
        $('#banner-panel').show().find('input').removeAttr('disabled');
    } else {
        $('#banner-panel').hide().find('input').attr('disabled', 'disabled');
    }
});

";
$this->registerJs($js);

if (!$model->url)
    $model->url = date('YmdHis') . '.html';
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'name'),['prompt'=>'请选择分类','encodeSpaces'=>true]) ?>
        <?= $form->field($model, 'from')->textInput() ?>
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'url')->textInput()->hint('如: article1.html') ?>

        <?= $form->field($model, 'content')->widget(Summernote::className(), [
            'clientOptions' => [
                'onChange' => new JsExpression("function(content, editable) { $('#article-short').val(content.replace(/<[^>]+>/g, '').replace(/[\\r\\n]/g, '').substr(0, 255) + '...'); }"),
            ]
        ]) ?>

        <?= $form->field($model, 'short')->textarea(['rows' => 5]) ?>

        <?= $form->field($model, 'pthumb')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*', 'name' => 'file', 'target' => 'article-thumb'],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['/file/upload?folder=article']),
                'initialPreview' => $model->thumb ? [Html::img("/file?id=" . $model->thumb, ['class'=>'file-preview-image'])] : [],
                'initialCaption'=>"已保存图片",
            ]
        ]); ?>

        <?= Html::activeHiddenInput($model, 'thumb'); ?>

        <?= $form->field($model, 'isbanner')->checkbox([], false)->hint('如果此文章希望在Banner处显示, 则勾选此项.') ?>
        <?php
            $options = [];
            $style = $model->isbanner ? "display: block;" : "display: none;";
            if (!$model->isbanner)
                $options['disabled'] = 'disabled';
        ?>
        <div id="banner-panel" style="<?= $style ?>">
            <?= $form->field($model, 'pbanner')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*', 'name' => 'file', 'target' => 'article-banner'],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['/file/upload?folder=article']),
                'initialPreview' => $model->banner ? [Html::img("/file?id=" . $model->banner, ['class'=>'file-preview-image'])] : [],
                'initialCaption'=>"已保存图片",
            ]
        ]); ?>
            <?= Html::activeHiddenInput($model, 'banner'); ?>
            <?= $form->field($model, 'banner_position')->textInput($options) ?>
        </div>
    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script></script>