<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('修改 {modelClass} #', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?> . ' ' . $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update') ?>;
?>
<div class="row" id="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= "<?= " ?>Html::encode($this->title) ?>
            </header>
            <div class="panel-body">
                <?= "<?= " ?>$this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </section>
    </div>
</div>
