<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app','Access Denied');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app','Access Denied')?>.</h1>
        <p>
            <a class="btn btn-warning" href="javascript:void(0);" onclick="history.go(-1);"><?= Yii::t('app','Back')?></a>
        </p>
    </div>
</div>
