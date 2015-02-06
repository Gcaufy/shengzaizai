<?php
use yii\helpers\Html;
use backend\components\ActiveForm;

$this->title = '系统配置';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?=$this->title?>
            </header>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'app_name')->textInput() ?>

                    <?= $form->field($model, 'version')->textInput() ?>

                    <?= $form->field($model, 'feature')->textarea() ?>

                    <?= $form->field($model, 'about')->textarea() ?>
                    <div class="right">
                        <?= Html::submitButton('<i class="fa fa-pencil"></i> '.Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>