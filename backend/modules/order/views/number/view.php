<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\Number */
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

$this->title = $model->id;
$this->params['breadcrumbs'][] = '查看预约号 #' . $model->id;
?>
<div class="row" id="number-view">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
            <p>
                <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '您真的要删除这条记录吗?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'hosp_id',
                    'opera_id',
                    'insp_id',
                    'doctor_id',
                    'order_num',
                    'active_order_num',
                    'date',
                    'start_time',
                    'end_time',
                    'isvip',
                    'cost',
                ],
            ]) ?>
            </div>
        </section>
    </div>
</div>
