<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\system\models\Region */

$this->title = '添加地区';
$this->params['breadcrumbs'][] = ['label' => '地区信息', 'url' => ['index']];
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
                ]) ?>
            </div>
        </section>
    </div>
</div>
