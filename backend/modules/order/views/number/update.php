<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\Number */
$typeMap = Order::getTypeMap();
$label = $ptype ? $typeMap[$ptype] : '';

$this->title = '修改 ' . $label . '预约号';
$this->params['breadcrumbs'][] = ['label' => '预约号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row" id="number-update">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </section>
    </div>
</div>
