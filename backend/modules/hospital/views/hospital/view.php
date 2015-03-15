<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\hospital\models\Hospital */

$this->title = '医院信息 - ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '医院列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="hospital-view">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading custom-tab dark-tab">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#profile">基本信息</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#doctor">医生列表</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#inspection">检查列表</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#operation">手术列表</a>
                    </li>
                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="profile" class="tab-pane active">
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
                        'name',
                        'addr',
                        'tel',
                        'region_id',
                        'opened_order',
                        'active_opened_order',
                            ],
                        ]) ?>
                    </div>
                    <div id="doctor" class="tab-pane">
                        <p>
                            <?= Html::a('新增', ['/doctor/doctor/create', 'hosp_id' => $model->id], ['class' => 'btn btn-success']) ?>
                        </p>
                        <?= GridView::widget([
                            'dataProvider' => $doctorProvider,
                            'filterModel' => $searchDoctor,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'id',
                                'name',
                                'desc',
                                'feedback_score',
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions'=>['width'=>180],
                                    'template'=>'{view} {update} {delete}',
                                    'buttons'=>[
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['/doctor/doctor/view', 'id' => $model->id],[
                                                'title'=>Yii::t('yii','View'),
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['/doctor/doctor/update', 'id' => $model->id],[
                                                'title'=>Yii::t('yii','Update'),
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                        'delete' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['/doctor/doctor/delete', 'id' => $model->id],[
                                                'title'=>Yii::t('yii','Delete'),
                                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                    ],
                                ],
                            ],
                        ]); ?>
                    </div>
                    <div id="inspection" class="tab-pane">
                        <p>
                            <?= Html::a('新增', ['/inspection/inspection/create', 'hosp_id' => $model->id], ['class' => 'btn btn-success']) ?>
                        </p>
                        <?= GridView::widget([
                            'dataProvider' => $inspProvider,
                            'filterModel' => $searchInsp,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'id',
                                'insp_id',
                                'hosp_id',
                                'contact',
                                'feedback_score',
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions'=>['width'=>180],
                                    'template'=>'{view} {update} {delete}',
                                    'buttons'=>[
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['/inspection/inspection/view', 'id' => $model->id],[
                                                'title'=>Yii::t('yii','View'),
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['/inspection/inspection/update', 'id' => $model->id],[
                                                'title'=>Yii::t('yii','Update'),
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                        'delete' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['/inspection/inspection/delete', 'id' => $model->id],[
                                                'title'=>Yii::t('yii','Delete'),
                                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                    ],
                                ],
                            ],
                        ]); ?>
                    </div>
                    <div id="operation" class="tab-pane">
                        <p>
                            <?= Html::a('新增', ['/operation/operation/create', 'hosp_id' => $model->id], ['class' => 'btn btn-success']) ?>
                        </p>
                        <?= GridView::widget([
                            'dataProvider' => $operaProvider,
                            'filterModel' => $searchOpera,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                    'id',
                                    'hosp_id',
                                    'opera_id',
                                    'contact',
                                    'feedback_score',
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions'=>['width'=>180],
                                    'template'=>'{view} {update} {delete}',
                                    'buttons'=>[
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['/operation/operation/view', 'id' => $model->id],[
                                                'title'=>Yii::t('yii','View'),
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['/operation/operation/update', 'id' => $model->id],[
                                                'title'=>Yii::t('yii','Update'),
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                        'delete' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['/operation/operation/delete', 'id' => $model->id],[
                                                'title'=>Yii::t('yii','Delete'),
                                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                    ],
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
