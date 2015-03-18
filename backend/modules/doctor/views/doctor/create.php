<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\doctor\models\Doctor */

$this->title = '添加医生';

if ($hospital) {
    $this->params['breadcrumbs'][] = ['label' => '医院列表', 'url' => ['/hospital/hospital/']];
    $this->params['breadcrumbs'][] = ['label' => '医院信息 - ' . $hospital->name, 'url' => ['/hospital/hospital/view', 'id' => $hospital->id]];
} else {
    $this->params['breadcrumbs'][] = ['label' => '医生列表', 'url' => ['index']];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
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
