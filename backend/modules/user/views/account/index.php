<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$this->title = '我的账户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="user-update">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title); ?>
                <span>余额为: <span style="color:red;"><?= $balance; ?></span></span>
            </header>
            <div class="panel-body">



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'order_no',
                'headerOptions' => ['style' => 'width: 160px;'],
            ],
            [
                'attribute' => 'direction',
                'value' => 'type',
                'filter' => \common\models\finance\GeneralLedger::getTypeMap(),
                'headerOptions' => ['style' => 'width: 80px;']
            ],
            'payment.desc',
            [
                'attribute' => 'amount',
                'filter' => false,
                'headerOptions' => ['style' => 'width: 120px;'],
                'contentOptions' => ['style' => 'text-align: right;']
            ],
            [
                'attribute' => 'ctime',
                'value' => 'ctime',
                'filter' => false,
                'format' => 'datetime',
                'headerOptions' => ['style' => 'width: 200px;']
            ],
        ],
    ]); ?>


            </div>
        </section>
    </div>
</div>
