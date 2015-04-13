
<div class="panel">
    <div class="panel-body">


    <div class="row">
    <div class="col-md-2">
        <div class="blog-img-sm">
            <img src="/file?thumb=150x150&id=<?= $model->thumb;?>" alt="" >
        </div>
    </div>
    <div class="col-md-10">
        <h1 class=""><a href="#"><?=$model->title;?></a></h1>
        <p class=" auth-row">
            来自 <a href="#"><?=$model->from;?></a>  | <a href="#"><?= $model->favor;?> 收藏</a> | <a href="#"><?= $model->positive;?> 点赞</a>
        </p>

        <p><?=$model->short;?>
        </p>
        <a href="#" class="more">
            <a href="view?id=<?=$model->id;?>" title="查看" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>
            <a href="update?id=<?=$model->id;?>" title="更新" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>
            <a href="delete?id=<?=$model->id;?>" title="删除" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>

        </a>
    </div>
</div>
    </div>
</div>
<br />