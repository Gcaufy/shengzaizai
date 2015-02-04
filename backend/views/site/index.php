<?php

use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = '动态提醒';
?>
<div class="row">
    <div class="col-md-4 col-sm-3 well">
        <h2>未读通知</h2>
        <p>您共有 <span class="red"><?= $unReadNote ?></span> 条未读消息 <a href="<?= Url::to(['message/note/index']); ?>">立即查看</a></p>
        <p>共有 <span class="red">0</span> 条老师反馈信息</p>
        <p>共有 <span class="red">0</span> 条新评论</p>
    </div>
    <div class="col-md-1 col-sm-2"></div>
    <div class="col-md-4 col-sm-3 well">
        <h2>作业信息</h2>
        <p>您本周已发 <span class="red">0</span> 条家庭作业信息 <span class="red">0</span> 条未读</p>
        <p>共有 <span class="red">0</span> 条语数外信息</p>
        <p>共有 <span class="red">0</span> 条其他作业信息</p>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-sm-3 well">
        <h2>资讯相关</h2>
        <p>您共有 <span class="red">0</span> 条资讯收藏</p>
        <p>共有 <span class="red">0</span> 评论动态</p>
    </div>
    <div class="col-md-1 col-sm-2"></div>
    <div class="col-md-4 col-sm-3 well">
        <h2>账户费用</h2>
        <p>你已缴费 <span class="blue">120.00</span> 元</p>
        <p>有效期至 <span class="red">0</span> 2015年7月31日</p>
    </div>
</div>
