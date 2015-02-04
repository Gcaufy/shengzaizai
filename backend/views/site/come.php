<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app','正在努力的开发中...');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app','此功能正在努力的开发中...')?>.</h1>
        <p>
            <a class="btn btn-warning" href="javascript:void(0);" onclick="history.go(-1);"><?= Yii::t('app','Back')?></a>
        </p>
    </div>
</div>
