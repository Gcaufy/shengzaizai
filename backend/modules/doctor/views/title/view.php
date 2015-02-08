<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\doctor\models\DoctorTitle */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Doctor Titles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="doctor-title-view">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
            <p>
                <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '您真的要删除这条记录吗?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
            'name',
            'status',
            'utime',
            'uid',
            'ctime',
            'cid',
                ],
            ]) ?>
            </div>
        </section>
    </div>
</div>
