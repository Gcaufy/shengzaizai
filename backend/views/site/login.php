<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use xj\supersized\Supersized;
?>
<?= Supersized::widget([
    'theme' => Supersized::THEME_SLIDESHOW,
    'options' => [
        'slide_interval' => 4000,
        'transition' => 1,
        'transition_speed' => 1000,
        'performance' => 1,
        'min_width' => 0,
        'min_height' => 0,
        'vertical_center' => 1,
        'horizontal_center' => 1,
        'fit_always' => 0,
        'fit_portrait' => 1,
        'fit_landscape' => 0,
        'slide_links' => 'blank',
        'slides' => [
            ['image' => '/img/1.jpg'],
            ['image' => '/img/2.jpg'],
            ['image' => '/img/3.jpg'],
        ],
    ],
]) ?>
<div class="page-container">
    <img src="/img/logo.png" width="148" height="98">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'username')->textInput(['placeholder' => '请输入您的用户名！'])->label('') ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入您的用户密码！'])->label('') ?>
        <?= Html::submitButton('登录', ['class' => 'submit_button', 'name' => 'login-button']) ?>
    <?php ActiveForm::end(); ?>
    <div class="connect">
        <?= Html::a('返回首页', Yii::$app->urlManager->createUrl('www', '/')); ?>
    </div>
</div>
