<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use backend\modules\order\models\Order;

/* @var $this yii\web\View */
/* @var $model backend\modules\hospital\models\Hospital */

$this->registerJsFile("js/fuelux/js/tree.js", ['depends' => 'backend\assets\AppAsset']);
$this->registerJsFile("js/hospitalinspection.js", ['depends' => 'backend\assets\AppAsset']);
$this->registerJsFile("js/jquery.mask.js", ['depends' => 'backend\assets\AppAsset']);
$this->registerCssFile("js/fuelux/css/fuelux.min.css", ['depends' => 'backend\assets\AppAsset']);
$this->registerCssFile("js/fuelux/css/tree-style.css", ['depends' => 'backend\assets\AppAsset']);

$this->title = '医院信息 - ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '医院列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
window.InspectionMap = window.InspectionMap || {}
window.InspectionMap.hospitalId = '<?= $model->id; ?>';
</script>
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
                                'feedback_manner',
                                'feedback_effect',
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions'=>['width'=>180],
                                    'template'=>'{oum} {view} {update} {delete}',
                                    'buttons'=>[
                                        'oum' => function ($url, $doc, $key) use ($model) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/order/number/index',
                                                    'pid' => $doc->id,
                                                    'hosp_id' => $model->id,
                                                    'ptype' => Order::TYPE_DOCTOR
                                                ],[
                                                    'title' => '预约号管理',
                                                    'data-pjax' => '0',
                                            ]);
                                        },
                                        'view' =>  function ($url, $doc, $key) use ($model) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['/doctor/doctor/view', 'id' => $doc->id, 'hosp_id' => $model->id],[
                                                'title'=>Yii::t('yii','View'),
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                        'update' => function ($url, $doc, $key) use ($model) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['/doctor/doctor/update', 'id' => $doc->id, 'hosp_id' => $model->id],[
                                                'title'=>Yii::t('yii','Update'),
                                                'data-pjax' => '0',
                                            ]);
                                        },
                                        'delete' => function ($url, $doc, $key) use ($model) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['/doctor/doctor/delete', 'id' => $doc->id, 'hosp_id' => $model->id],[
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

                        <div class="col-md-6" id="inspection-left">
                            <section class="panel">
                                <header class="panel-heading">
                                    检查项目
                                </header>
                                <div class="panel-body" style="min-height: 300px;">
                                    <div class="fuelux">
                                        <ul class="tree tree-solid-line" role="tree" id="tree" style="min-height: 300px;">
                                            <li class="tree-branch hide" data-template="treebranch" role="treeitem" aria-expanded="false">
                                                <div class="tree-branch-header">
                                                    <button class="tree-branch-name">
                                                        <i class="glyphicon icon-caret glyphicon-play"></i>
                                                        <i class="item-check"> </i>
                                                        <i class="glyphicon icon-folder glyphicon-folder-close"></i>
                                                        <span class="tree-label"></span>
                                                    </button>
                                                </div>
                                                <ul class="tree-branch-children" role="group"></ul>
                                                <div class="tree-loader" role="alert">Loading...</div>
                                            </li>
                                            <li class="tree-item hide" data-template="treeitem" role="treeitem">
                                                <button class="tree-item-name">
                                                    <i class="item-check"> </i>
                                                    <i class="icon-item"></i>
                                                    <span class="tree-label"></span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-6" id="inspection-right">
                            <section class="panel">
                                <header class="panel-heading">
                                    详情
                                </header>
                                <div class="panel-body" style="min-height: 300px;">
                                </div>
                            </section>
                        </div>
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
                                    'opera.name',
                                    'contact',
                                    'feedback_manner',
                                    'feedback_effect',
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
