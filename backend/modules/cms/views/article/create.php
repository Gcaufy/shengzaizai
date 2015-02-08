<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\Article */

$this->title = '添加 文章';
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
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
