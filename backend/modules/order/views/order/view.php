<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="order-view">
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
            'order_no',
            'hosp_id',
            'opera_id',
            'opera_name',
            'insp_id',
            'insp_name',
            'doctor_id',
            'doctor_job_title',
            'doctor_name',
            'address',
            'date',
            'start_time',
            'end_time',
            'type',
            'payment_method',
            'payment_id',
            'refund_id',
            'cost',
            'process',
            'utime:datetime',
            'ctime:datetime',
                ],
            ]) ?>
            </div>
        </section>
    </div>
</div>
