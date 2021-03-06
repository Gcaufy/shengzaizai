<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\order\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\NumberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$typeMap = Order::getTypeMap();
$label = $ptype ? $typeMap[$ptype] : '';


if ($hospital) {
    $this->params['breadcrumbs'][] = ['label' => '医院列表', 'url' => ['/hospital/hospital/']];
    $this->params['breadcrumbs'][] = ['label' => '医院信息 - ' . $hospital->name, 'url' => ['/hospital/hospital/view', 'id' => $hospital->id]];
    if ($doctor)
        $this->params['breadcrumbs'][] = ['label' => '医生 - ' . $doctor->name, 'url' => ['/doctor/doctor/view', 'id' => $doctor->id, 'hosp_id' => $hospital->id]];
    if ($inspection)
        $this->params['breadcrumbs'][] = ['label' => '检查 - ' . $inspection->name, 'url' => ['/inspection/inspection/view', 'id' => $inspection->id, 'hosp_id' => $hospital->id]];
    if ($operation)
        $this->params['breadcrumbs'][] = ['label' => '手术 - ' . $operation->name, 'url' => ['/operation/operation/view', 'id' => $operation->id, 'hosp_id' => $hospital->id]];
}

$this->title = $label . '预约号列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="number-index">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php if ($ptype && $pid && $hosp_id): ?>
                    <p><?= Html::a('新增', ['create' ,'ptype' => $ptype, 'pid' => $pid, 'hosp_id' => $hosp_id], ['class' => 'btn btn-success']) ?></p>
                <?php endif; ?>

                <?php
                    $columns = [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'order_num',
                        'active_order_num',
                        'date',
                        'start_time',
                        'end_time',
                    ];
                    if ($hosp_id && $ptype && $pid) {
                            $columns[] = [
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['width'=>180],
                                'template'=>'{view} {update} {delete}',
                                'buttons'=>[
                                    'view' => function ($url, $model, $key) use($ptype, $pid, $hosp_id) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['view',
                                            'id' => $model->id,
                                            'ptype' => $ptype,
                                            'pid' => $pid,
                                            'hosp_id' => $hosp_id,
                                        ],[
                                            'title'=>Yii::t('yii','View'),
                                            'data-pjax' => '0',
                                        ]);
                                    },
                                    'update' => function ($url, $model, $key) use($ptype, $pid, $hosp_id) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['update',
                                            'id' => $model->id,
                                            'ptype' => $ptype,
                                            'pid' => $pid,
                                            'hosp_id' => $hosp_id,
                                        ],[
                                            'title'=>Yii::t('yii','Update'),
                                            'data-pjax' => '0',
                                        ]);
                                    },
                                    'delete' => function ($url, $model, $key) use($ptype, $pid, $hosp_id) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete',
                                            'id' => $model->id,
                                            'ptype' => $ptype,
                                            'pid' => $pid,
                                            'hosp_id' => $hosp_id,
                                        ],[
                                            'title'=>Yii::t('yii','Delete'),
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                        ]);
                                    },
                                ],
                            ];
                    } else {
                        $columns[] = ['class' => 'yii\grid\ActionColumn'];
                    }
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $columns
                ]); ?>


            </div>
        </section>
    </div>
</div>
