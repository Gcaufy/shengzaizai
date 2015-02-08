<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\operation\models\OperationHospitalMap */

$this->title = '修改 Operation Hospital Map #' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Operation Hospital Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row" id="operation-hospital-map-update">
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
