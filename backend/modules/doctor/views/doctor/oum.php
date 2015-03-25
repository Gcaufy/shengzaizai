<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\doctor\models\DoctorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '医生订单号列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="doctor-oum-index">
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
            'name',
            'desc',
            'feedback_manner',
            'feedback_effect',

            ['class' => 'yii\grid\ActionColumn',
                'headerOptions'=>['width'=>180],
                'template'=>'{oum} {view} {update} {delete}',
                'buttons'=>[
                    'oum' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['/doctor/doctor/oum', 'id' => $model->id],[
                            'title' => '订单号管理',
                            'data-pjax' => '0',
                        ]);
                    },
                    },
                ],
            ],
        ],
    ]); ?>


            </div>
        </section>
    </div>
</div>
