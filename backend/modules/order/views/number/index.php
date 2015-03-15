<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\order\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\NumberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$typeMap = Order::getTypeMap();
$label = $ptype ? $typeMap[$ptype] : '';

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

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'order_num',
                        'active_order_num',
                        'date',
                        'start_time',
                        'end_time',
                        // 'type',
                        // 'cost',
                        // 'status',
                        // 'utime:datetime',
                        // 'uid',
                        // 'ctime:datetime',
                        // 'cid',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>


            </div>
        </section>
    </div>
</div>
