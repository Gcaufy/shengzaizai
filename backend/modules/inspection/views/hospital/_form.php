<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\helpers\Url;
use kartik\rating\StarRating;
use backend\modules\order\models\Order;

/* @var $this yii\web\View */
/* @var $model backend\modules\inspection\models\InspectionHospitalMap */
/* @var $form yii\widgets\ActiveForm */

$inspection = isset($inspection) ? $inspection : null;
$hospital = isset($hospital) ? $hospital : null;
?>

<div class="inspection-hospital-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (Yii::$app->request->isAjax):?>
        <?= $form->field($model, 'hosp_id')->textInput(['value' => $hospital->name, 'disabled' => 'disabled']) ?>
        <?= $form->field($model, 'insp_id')->textInput(['value' => $inspection->name, 'disabled' => 'disabled']) ?>
    <?php else: ?>
        <?= $form->field($model, 'insp_id')->ajaxSelect(Url::to('inspsearch'), ['options' => ['placeholder' => '请选择父级']]) ?>

        <?= $form->field($model, 'hosp_id')->ajaxSelect(Url::to('hospsearch'), ['options' => ['placeholder' => '请选择父级']]) ?>
    <?php endif;?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'feedback_score')->widget(StarRating::classname(), [
        'pluginOptions' => ['step' => 1, 'showCaption' => false, 'showClear' => false, 'size' => 'xs', 'hoverEnabled' => 'false']
    ]); ?>

    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['id' => 'btn_submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php if (Yii::$app->request->isAjax):?>
        <div class="form-group left">
        <?= Html::a('管理预约号', Url::to(['/order/number/index', 'ptype' => Order::TYPE_INSPECTION, 'pid' => $inspection->id, 'hosp_id' => $hospital->id]), ['class' => 'btn btn-success']); ?>
        </div>
    <?php endif;?>

    <?php ActiveForm::end(); ?>

</div>
