<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app','Message Tips');
?>
<div class="panel panel-<?= $model['e']?> message">
  <div class="panel-heading"><?=Yii::t('app','Message Tips')?></div>
  <div class="panel-body">
    <?= $model['i'] ?>
  </div>
  <div class="panel-footer text-center"><a href="<?= empty($model['u']) ? 'javascript:void(0);' : $model['u']?>" class="btn btn-<?= $model['e']?>"<?= empty($model['u']) ? ' onclick="history.go(-1);"' : ''?>><?=Yii::t('app','Back')?></a></div>
</div>