<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\inspection\models\InspectionHospitalMap */

$this->title = '修改 Inspection Hospital Map #' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inspection Hospital Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row" id="inspection-hospital-map-update">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </section>
    </div>
</div>
