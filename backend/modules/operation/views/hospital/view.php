<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\operation\models\OperationHospitalMap */

$this->title = $model->opera->name;

if ($hospital) {
    $this->params['breadcrumbs'][] = ['label' => '医院列表', 'url' => ['/hospital/hospital/']];
    $this->params['breadcrumbs'][] = ['label' => '医院信息 - ' . $hospital->name, 'url' => ['/hospital/hospital/view', 'id' => $hospital->id]];
} else {
    $this->params['breadcrumbs'][] = ['label' => '医院手术列表', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="operation-hospital-map-view">
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
            'contact',
            'feedback_manner',
            'feedback_effect',
            'utime:datetime',
            'ctime:datetime',
                ],
            ]) ?>
            </div>
        </section>
    </div>
</div>
