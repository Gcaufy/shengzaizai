<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\Article */

$this->title = '修改 文章 #' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row" id="article-update">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'categories' => $categories,
                ]) ?>
            </div>
        </section>
    </div>
</div>
