<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\operation\models\OperationHospitalMapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '医院手术列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="operation-hospital-map-index">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
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
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'hosp_id',
            'opera_id',
            'contact',
            // 'status',
            // 'utime',
            // 'uid',
            // 'ctime',
            // 'cid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


            </div>
        </section>
    </div>
</div>
