<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
?>
<div class="site-index">
    <div class="banner">
        <div class="items">
        <?php 
            if (isset(Yii::$app->params['cmsclass']) && isset(Yii::$app->params['cmsclass'][$id]['thumb'])) {
                $thumb = Yii::$app->params['cmsclass'][$id]['thumb'];
                if(!empty($thumb) && !strstr($thumb, 'http://')){
                    $thumb = '//' . Yii::$app->params['imageroot'].$thumb;
                }
                echo "<a href=\"\" style=\"background:url($thumb) no-repeat center;\"></a>";
            }
        ?>
            <a href="" style="background:url(/images/banner_01.png) no-repeat center;"></a>
            <a href="" style="background:url(/images/banner_02.png) no-repeat center;"></a>
            <a href="" style="background:red;"></a>
            <a href="" style="background:gray;"></a>
            <a href="" style="background:orange;"></a>
        </div>
    </div>
   
    <div class="content clearfix">
        <div class="content-left">
            <div class="section">
                <div class="section-title">
                    <span class="section-title-text">
                        推荐内容
                    </span>
                    <span class="section-more">
                        <?= Html::a('更多', ['article/list']) ?>
                    </span>
                </div>
                <div class="section-content">
                    <?php
                        if(isset(Yii::$app->params['alist'])){
                            foreach (Yii::$app->params['alist'] as $k => $v) {?>
                                <div class="media">
                                  <a class="media-left" href="#">
                                    <img src="<?= strstr($v['thumb'],'http://') ? $v['thumb'] : '//' . Yii::$app->params['imageroot'].$v['thumb'] ?>" alt="<?=$v['title']?>">
                                  </a>
                                  <div class="media-body">
                                    <h4 class="media-heading"><a href="<?=Url::to(['article/index', 'id'=>$v['id']]);?>"><?=$v['title']?></a></h4>
                                    <div class="media-info">
                                        <i class="fa fa-eye"></i> <span><?=$v['acclaim']?> </span>
                                        <i class="sp"></i>
                                        <i class="fa fa-heart"></i> <span><?=$v['comment']?> </span>
                                        <span class="media-date"><?=date("Y-m-d H:i", $v['ctime'])?></span>
                                    </div>
                                    <?=$v['description']?>

                                  </div>
                                </div>
                            <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="sidebar">
            <div class="section hot">
                <div class="section-title section-title-mid">
                    <span class="section-title-text">
                        热门标签
                    </span>
                </div>
                <div class="section-content">
                <style>
                    .bq_01 {
                        background: none repeat scroll 0 0 #fff;
                        border-bottom-left-radius: 8px;
                        border-bottom-right-radius: 8px;
                        padding-bottom: 15px;
                        padding-top: 15px;
                    }
                    .bq_01 p {
                        height: 35px;
                    }
                    .bq_01 a {
                        color: #333;
                        display: inline-block;
                        float: left;
                        font-size: 18px;
                        line-height: 35px;
                        padding: 0 6px 0 0;
                    }
                </style>
                <div class="bq_01 hz">
                    <p>
                        <a href="">亲子教育</a>
                        <a href="">户外拓展</a>
                        <a style="font-size:20px;" href="">课外补习</a>
                    </p>
                    <p>
                        <a style="font-size:22px;" href="">高考志愿</a>
                        <a href="">学习</a>
                        <a href="">名师名课</a>
                    </p>
                    <p>
                        <a href="">中国美术学院</a>
                        <a href="">艺校</a>
                        <a href="">美术招生</a>
                    </p>
                    <p>
                        <a href="">清华大学</a>
                        <a href="">金融专业</a>
                        <a href="">工程院士 </a>
                    </p>
                    <p>
                        <a href="">土木工程</a>
                        <a style="font-size:22px;" href="">小语种补习</a>
                    </p>
                    <p>
                        <a href="">升学率</a>
                        <a href="">孩子心理健康</a>
                        <a href="">升学</a>
                    </p>
                    <p>
                        <a href="">小升初</a>
                        <a href="">毕业工作</a>
                        <a style="font-size:20px;" href="">小学营养餐</a>
                    </p>
                    <p>
                        <a href="">幼儿园启蒙</a>
                        <a href="">儿童健康</a>
                        <a href="">校车安全</a>
                    </p>
                </div>
                </div>
            </div>
            <div class="section awsome">
                <div class="section-title section-title-mid">
                    <span class="section-title-text">
                        论坛精华
                    </span>
                </div>
                <div class="section-content">
                </div>
            </div>
        </div>
    </div>

    <div class="ad clearfix">
        <div class="ad-left">
            <img alt="" src="../images/ad.png">
        </div>
        <div class="ad-right">
            <img alt="" src="../images/bq_01.png">
        </div>
    </div>
    <div class="content">
        <div class="section">
            <div class="section-title">
                <span class="section-title-text">
                    热点聚焦
                </span>
                <span class="section-more">
                    <?= Html::a('更多', ['article/list', 'id' => 1]) ?>
                </span>
            </div>
            <div class="section-content">
                <?php
                    if(isset(Yii::$app->params['alist'])){
                        foreach (Yii::$app->params['alist'] as $k => $v) {?>
                            <div class="media">
                              <a class="media-left" href="#">
                                <img src="<?= strstr($v['thumb'],'http://') ? $v['thumb'] : '//' . Yii::$app->params['imageroot'].$v['thumb'] ?>" alt="<?=$v['title']?>">
                              </a>
                              <div class="media-body">
                                <h4 class="media-heading"><a href="<?=Url::to(['article/index', 'id'=>$v['id']]);?>"><?=$v['title']?></a></h4>
                                <div class="media-info">
                                    <i class="fa fa-eye"></i> <span><?=$v['acclaim']?> </span>
                                    <i class="sp"></i>
                                    <i class="fa fa-heart"></i> <span><?=$v['comment']?> </span>
                                    <span class="media-date"><?=date("Y-m-d H:i", $v['ctime'])?></span>
                                </div>
                                <?=$v['description']?>

                              </div>
                            </div>
                        <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="float-tip">
        <div class="tip-item">
            <div class="tip-img"></div>
            <div class="tip-text">关注微信</div>
        </div>
        <!--div class="tip-item">
            <div class="tip-img"></div>
            <div class="tip-text">下载APP</div>
        </div-->
        <div class="tip-item back-top">
            <div class="tip-text-back-top">
                返回<br/>顶部
            </div>
        </div>
    </div>
</div>
