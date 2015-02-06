<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Feedback */


$this->title = '修改用户反馈' . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '用户反馈', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?=$this->title?>
            </header>
            <div class="panel-body">
                <?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
            </div>
        </section>
    </div>
</div>
