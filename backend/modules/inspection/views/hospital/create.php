<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\inspection\models\InspectionHospitalMap */

$this->title = '添加 医院检查';
$this->params['breadcrumbs'][] = ['label' => '医院检查列表', 'url' => ['index']];
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
                    'inspection' => $inspection,
                    'hospital' => $hospital,
                ]) ?>
            </div>
        </section>
    </div>
</div>
