<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= "<?= " ?>Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
            <p>
                <?= "<?= " ?>Html::a(<?= $generator->generateString('修改') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
                <?= "<?= " ?>Html::a(<?= $generator->generateString('删除') ?>, ['delete', <?= $urlParams ?>], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => <?= $generator->generateString('您真的要删除这条记录吗?') ?>,
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= "<?= " ?>DetailView::widget([
                'model' => $model,
                'attributes' => [
        <?php
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {
                echo "            '" . $name . "',\n";
            }
        } else {
            foreach ($generator->getTableSchema()->columns as $column) {
                $format = $generator->generateColumnFormat($column);
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        }
        ?>
                ],
            ]) ?>
            </div>
        </section>
    </div>
</div>
