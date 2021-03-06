<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\operation\models\Operation */

$this->title = '修改手术 #' . ' ' . $model->name;
if ($hospital) {
    $this->params['breadcrumbs'][] = ['label' => '医院列表', 'url' => ['/hospital/hospital/']];
    $this->params['breadcrumbs'][] = ['label' => '医院信息 - ' . $hospital->name, 'url' => ['/hospital/hospital/view', 'id' => $hospital->id]];
} else {
    $this->params['breadcrumbs'][] = ['label' => '手术列表', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
}

$this->params['breadcrumbs'][] = '修改';
?>
<div class="row" id="operation-update">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'hospital' => $hospital,
                ]) ?>
            </div>
        </section>
    </div>
</div>
