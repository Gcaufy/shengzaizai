<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\doctor\models\Doctor */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '医生列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="doctor-view">
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
            'hosp_id',
            'name',
            'desc',
            'feedback_score',
            'normal_reg_cost',
            'expert_reg_cost',
            'order_num',
            'active_order_num',
            'major',
            'experience',
            'note',
            'isvip',
            'type',
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
