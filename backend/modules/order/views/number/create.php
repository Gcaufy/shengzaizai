<?php

use yii\helpers\Html;
use backend\modules\order\models\Order;


/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\Number */
$typeMap = Order::getTypeMap();
$label = $ptype ? $typeMap[$ptype] : '';

$this->title = '添加 ' . $label . '预约号';

if ($hospital) {
    $this->params['breadcrumbs'][] = ['label' => '医院列表', 'url' => ['/hospital/hospital/']];
    $this->params['breadcrumbs'][] = ['label' => '医院信息 - ' . $hospital->name, 'url' => ['/hospital/hospital/view', 'id' => $hospital->id]];
    if ($doctor)
        $this->params['breadcrumbs'][] = ['label' => '医生 - ' . $doctor->name, 'url' => ['/doctor/doctor/view', 'id' => $doctor->id, 'hosp_id' => $hospital->id]];
    if ($inspection)
        $this->params['breadcrumbs'][] = ['label' => '检查 - ' . $inspection->name, 'url' => ['/inspection/inspection/view', 'id' => $inspection->id, 'hosp_id' => $hospital->id]];
    if ($operation)
        $this->params['breadcrumbs'][] = ['label' => '手术 - ' . $operation->name, 'url' => ['/operation/operation/view', 'id' => $operation->id, 'hosp_id' => $hospital->id]];
    $this->params['breadcrumbs'][] = ['label' => '预约号列表', 'url' => ['index', 'pid' => $pid, 'ptype' => $ptype, 'hosp_id' => $hosp_id]];
} else
    $this->params['breadcrumbs'][] = ['label' => '预约号列表', 'url' => ['index']];




$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'ptype' => $ptype,
                    'pid' => $pid,
                    'hosp_id' => $hosp_id,
                    'hospital' => $hospital,
                    'doctor' => $doctor,
                    'inspection' => $inspection,
                    'operation' => $operation,
                ]) ?>
            </div>
        </section>
    </div>
</div>
