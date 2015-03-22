<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\helpers\ArrayHelper;
use Zelenin\yii\widgets\Summernote\Summernote;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'name'),['prompt'=>'请选择分类','encodeSpaces'=>true]) ?>


    <?= $form->field($model, 'from')->textInput() ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'short')->textInput() ?>

    <?= $form->field($model, 'content')->widget(Summernote::className(), [
    ]) ?>

    <?= $form->field($model, 'thumb')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'options' => ['name' => 'file'],
        'pluginOptions' => [
            'uploadUrl' => Url::to(['/file/upload?folder=article']),
            'maxFileCount' => 10,
        ]
    ]); ?>

    <?= $form->field($model, 'banner')->textInput() ?>

    <?= $form->field($model, 'banner_position')->textInput() ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
