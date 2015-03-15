<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="order-index">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                                <p>
                    <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
                </p>





    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_no',
            'hosp_id',
            'opera_id',
            'opera_name',
            // 'insp_id',
            // 'insp_name',
            // 'doctor_id',
            // 'doctor_job_title',
            // 'doctor_name',
            // 'address',
            // 'date',
            // 'start_time',
            // 'end_time',
            // 'type',
            // 'payment_method',
            // 'payment_id',
            // 'refund_id',
            // 'cost',
            // 'process',
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
