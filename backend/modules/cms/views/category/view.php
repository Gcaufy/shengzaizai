<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Feedback */


$this->title = '查看资讯分类' . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '资讯分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?=$this->title?>
            </header>
            <div class="panel-body">
            <p>
                <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'utime:datetime',
                    'uid',
                    'ctime:datetime',
                    'cid',
                ],
            ]) ?>
            </div>
        </section>
    </div>
</div>
