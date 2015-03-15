<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\Number */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                    'type',
                    'cost',
                ],
            ]) ?>
            </div>
        </section>
    </div>
</div>
