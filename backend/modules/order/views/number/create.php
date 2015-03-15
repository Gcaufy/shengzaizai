<?php

use yii\helpers\Html;
use backend\modules\order\models\Order;


/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\Number */
$typeMap = Order::getTypeMap();
$label = $ptype ? $typeMap[$ptype] : '';

$this->title = '添加 ' . $label . '预约号';
$this->params['breadcrumbs'][] = ['label' => '预约号列表', 'url' => ['index']];
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
                    'ptype' => $ptype,
                    'pid' => $pid,
                    'hosp_id' => $hosp_id,
                ]) ?>
            </div>
        </section>
    </div>
</div>
