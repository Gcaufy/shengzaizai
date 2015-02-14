<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\inspection\models\Inspection */

$this->title = '修改检查 #' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '检查列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row" id="inspection-update">
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
