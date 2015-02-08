<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cms\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="article-index">
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
            'category_id',
            'title',
            //'short',
            //'content',
            // 'favor',
            // 'positive',
            // 'thumb',
            // 'banner',
            // 'banner_position',
            // 'from',
            // 'status',
            // 'utime:datetime',
            // 'uid',
            // 'ctime:datetime',
            // 'cid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


            </div>
        </section>
    </div>
</div>
