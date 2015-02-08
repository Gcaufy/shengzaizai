<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\operation\models\Operation */

$this->title = '修改 Operation #' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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
                ]) ?>
            </div>
        </section>
    </div>
</div>
