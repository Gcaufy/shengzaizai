<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\order\models\Order;

/* @var $this yii\web\View */
/* @var $model backend\modules\doctor\models\Doctor */

$this->title = $model->name;

if ($hospital) {
    $this->params['breadcrumbs'][] = ['label' => '医院列表', 'url' => ['/hospital/hospital/']];
    $this->params['breadcrumbs'][] = ['label' => '医院信息 - ' . $hospital->name, 'url' => ['/hospital/hospital/view', 'id' => $hospital->id]];
} else {
    $this->params['breadcrumbs'][] = ['label' => '医生列表', 'url' => ['index']];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="doctor-view">


    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
            <p>
                <?= Html::a('添加预约号', ['/order/number/create', 'pid' => $model->id, 'hosp_id' => $hospital->id, 'ptype' => Order::TYPE_DOCTOR], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '您真的要删除这条记录吗?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            </div>
        </section>
    </div>
    <div class="col-md-4">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="profile-pic text-center">
                        <img src="/file?thumb=150x150&id=<?= $model->portrait; ?>" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'hosp_id',
                            'name',
                            'tag',
                            'title',
                            //'desc',
                            'feedback_manner',
                            'feedback_effect',
                            'normal_reg_cost',
                            'expert_reg_cost',
                            'order_num',
                            'active_order_num',
                            //'major',
                            //'experience',
                            //'note',
                            'isvip',
                            'type',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <header class="panel-heading">
                        <?= $model->attributeLabels()['desc'];?>
                    </header>
                    <div class="panel-body">
                        <?= $model->desc;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <header class="panel-heading">
                        <?= $model->attributeLabels()['major'];?>
                    </header>
                    <div class="panel-body">
                        <?= $model->major;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <header class="panel-heading">
                        <?= $model->attributeLabels()['experience'];?>
                    </header>
                    <div class="panel-body">
                        <?= $model->experience;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <header class="panel-heading">
                        <?= $model->attributeLabels()['note'];?>
                    </header>
                    <div class="panel-body">
                        <?= $model->note;?>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>
