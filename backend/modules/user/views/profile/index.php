<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$this->title = '我的资料';
$this->params['breadcrumbs'][] = $this->title;
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
