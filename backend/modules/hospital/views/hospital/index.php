<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\hospital\models\HospitalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '医院列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="hospital-index">
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
            'name',
            'tel',
            'opened_order',
            'active_opened_order',
            'hot',
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
