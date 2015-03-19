<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\inspection\models\InspectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '检查列表';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile("js/fuelux/js/tree.js", ['depends' => 'backend\assets\AppAsset']);
$this->registerJsFile("js/inspection.js", ['depends' => 'backend\assets\AppAsset']);
$this->registerJsFile("js/jquery.mask.js", ['depends' => 'backend\assets\AppAsset']);
$this->registerCssFile("js/fuelux/css/fuelux.min.css", ['depends' => 'backend\assets\AppAsset']);
$this->registerCssFile("js/fuelux/css/tree-style.css", ['depends' => 'backend\assets\AppAsset']);
?>
<div class="row" id="inspection-index">
    <div class="col-md-6" id="inspection-left">
        <section class="panel">
            <header class="panel-heading">
                检查项目
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                </span>
            </header>
            <div class="panel-body" style="min-height: 300px;">
                <div class="fuelux">
                    <ul class="tree tree-solid-line" role="tree" id="tree" style="min-height: 300px;">
                        <li class="tree-branch hide" data-template="treebranch" role="treeitem" aria-expanded="false">
                            <div class="tree-branch-header">
                                <button class="tree-branch-name">
                                    <i class="glyphicon icon-caret glyphicon-play"></i>
                                    <!--i class="glyphicon item-check fueluxicon-bullet"></i-->
                                    <i class="glyphicon icon-folder glyphicon-folder-close"></i>
                                    <span class="tree-label"></span>
                                </button>
                                <div class="tree-actions">
                                    <i class="fa fa-plus"></i>
                                    <i class="fa fa-pencil"></i>
                                    <i class="fa fa-trash-o"></i>
                                </div>
                            </div>
                            <ul class="tree-branch-children" role="group"></ul>
                            <div class="tree-loader" role="alert">Loading...</div>
                        </li>
                        <li class="tree-item hide" data-template="treeitem" role="treeitem">
                            <button class="tree-item-name">
                                <!--i class="glyphicon item-check fueluxicon-bullet"></i-->
                                <i class="icon-item"></i>
                                <span class="tree-label"></span>
                            </button>
                            <div class="tree-actions">
                                <i class="fa fa-plus"></i>
                                <i class="fa fa-pencil"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
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
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                </span>
            </header>
            <div class="panel-body" style="min-height: 300px;">
            </div>
        </section>
    </div>


    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                </span>
            </header>
            <div class="panel-body">
                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                                <p>
                    <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
                </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


            </div>
        </section>
    </div>
</div>
