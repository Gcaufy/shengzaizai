<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\doctor\models\DoctorTitle */

$this->title = '添加 Doctor Title';
$this->params['breadcrumbs'][] = ['label' => 'Doctor Titles', 'url' => ['index']];
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
