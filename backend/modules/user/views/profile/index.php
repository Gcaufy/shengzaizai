<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\grid\GridView;
use kartik\widgets\FileInput;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$this->title = '我的资料';
$this->params['breadcrumbs'][] = $this->title;

$js = "
$('input[name=file]').on('fileuploaded', function(event, data, previewId, index) {
    var response = data.response;
    if (response && response.result && response.result.length === 1) {
        $('#' + $(this).attr('target')).val(response.result[0]);
    }
});

";
$this->registerJs($js);
?>
<div class="row" id="user-update">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
                <div class="user-form">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($user, 'mobile')->textInput(['disabled' => 'disabled']) ?>

                    <?= $form->field($user, 'realname')->textInput(['maxlength' => 50]) ?>

                    <?= $form->field($user, 'email')->textInput(['maxlength' => 50]) ?>

                    <?= $form->field($user, 'pportrait')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*', 'name' => 'file', 'target' => 'user-portrait'],
                        'pluginOptions' => [
                            'uploadUrl' => Url::to(['/file/upload?folder=user']),
                            'initialPreview' => $user->portrait ? [Html::img("/file?id=" . $user->portrait, ['class'=>'file-preview-image'])] : [],
                            'initialCaption'=>"已保存图片",
                        ]
                    ]); ?>

                    <?= Html::activeHiddenInput($user, 'portrait'); ?>

                    <?php if (!$user->isMember()): ?>
                        <?= $form->field($user, 'pregnant')->radioList(\common\models\User::getTypeMap()) ?>
                    <?php endif;?>

                    <div class="form-group right">
                        <?= Html::submitButton($user->isNewRecord ? '创建' : '保存', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </section>
    </div>
</div>
