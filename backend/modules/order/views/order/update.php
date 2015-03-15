<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\Order */

$this->title = '修改 Order #' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row" id="order-update">
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
