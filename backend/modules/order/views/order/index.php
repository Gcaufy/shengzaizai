<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\order\models\Order;
use backend\components\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单管理';
$this->params['breadcrumbs'][] = $this->title;


$js = "
    $(document).on('click', '.btn_mark a', function () {
        var id = $(this).parents('div:eq(0)').attr('data'),
            val = $(this).attr('data');
        $('#order-process').val(val);
        $('#order-id').val(id);
        $('form').submit();
    });
";
$this->registerJs($js);
?>

<div class="row" id="order-index">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'order_no',
            [
                'attribute' => 'puser',
                'filter' => true,
                'value' => function ($model) {return isset($model->user) ? $model->user->realname : '';},
            ],
            [
                'attribute' => 'pordername',
                'filter' => true,
                'value' => function ($model) {
                    if ($model->opera_id)
                        return $model->opera_name;
                    else if ($model->insp_id)
                        return $model->insp_name;
                    else
                        return $model->doctor_name;
                },
            ],
            [
                'attribute' => 'type',
                'value' => 'typeDesc',
                'filter' => backend\modules\order\models\Order::getTypeMap(),
                'headerOptions' => ['style' => 'width: 120px;']
            ],
            'date',
            'start_time',
            'end_time',
            [
                'attribute' => 'process',
                'format' => 'html',
                'value' => function ($model) {
                    $html = '';
                    switch ($model->process) {
                        case Order::PROCESS_NEW:
                            $html = '<span class="label label-info">' . $model->processDesc . '</span>';
                            break;
                        case Order::PROCESS_DONE:
                            $html = '<span class="label label-success">' . $model->processDesc . '</span>';
                            break;
                        case Order::PROCESS_DUE:
                            $html = '<span class="label label-warning">' . $model->processDesc . '</span>';
                            break;
                        case Order::PROCESS_CANCEL:
                            $html = '<span class="label label-danger">' . $model->processDesc . '</span>';
                            break;
                    }
                    return $html;

                },
                'filter' => backend\modules\order\models\Order::getProcessMap(),
                'headerOptions' => ['style' => 'width: 120px;']
            ],
            // 'insp_id',
            // 'insp_name',
            // 'doctor_id',
            // 'doctor_job_title',
            // 'doctor_name',
            // 'address',
            // 'date',
            // 'start_time',
            // 'end_time',
            // 'type',
            // 'payment_method',
            // 'payment_id',
            // 'refund_id',
            // 'cost',
            // 'process',
            // 'status',
            // 'utime:datetime',
            // 'uid',
            // 'ctime:datetime',
            // 'cid',

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width'=>180],
                'template'=>'{mark}',
                'buttons'=>[
                    'mark' => function ($url, $model, $key) {
                        return Yii::$app->controller->getProcessGridButton($model->id);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php $form = ActiveForm::begin(); ?>
        <input type='hidden' name='process' id='order-process' />
        <input type='hidden' name='id' id='order-id' />
    <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
