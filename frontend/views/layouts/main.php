<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

use backend\modules\message\models\Note;
use backend\modules\message\models\NoteRead;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>
    <?= Html::encode(Yii::$app->name . ($this->title ? ' - ' . $this->title : ''))?>
    </title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'mnav mnav-fix',
                ],
            ]);

            $menuItems = [];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = [
                    'label' => '登录',
                    'url' => Yii::$app->urlManager->createUrl('man', 'site/login'),
                ];
            } else {
                $menuItems[] = [
                    'label' => Yii::$app->user->identity->realname,
                    'url' => Yii::$app->urlManager->createUrl('man', 'site/index'),
                    'options' => ['class' => 'navbar-user-info']
                ];
            }

            $unReadNote = false;
            $unReadMessage = false;
            $unReadHomework = false;
            if (!Yii::$app->user->isGuest) {
                $unReadNote = Note::find()->joinWith('unReadNote')->count('DISTINCT `t`.`id`');
            }

            $menuItems[] = [
                'label' => '通知' . ($unReadNote ? "($unReadNote)" : ''),
                'url' => Yii::$app->urlManager->createUrl('man', 'message/note/index'),
                'options' => ['class' => 'navbar-item'],
            ];
            $menuItems[] = [
                'label' => '消息' . ($unReadMessage ? "($unReadNote)" : ''),
                'url' => Yii::$app->urlManager->createUrl('man', 'message/note/index'),
                'options' => ['class' => 'navbar-item'],
            ];
            $menuItems[] = [
                'label' => '作业' . ($unReadHomework ? "($unReadNote)" : ''),
                'url' => Yii::$app->urlManager->createUrl('man', 'academic/homework/index'),
                'options' => ['class' => 'navbar-item'],
            ];
            if (!Yii::$app->user->isGuest) {
                $menuItems[] = [
                    'label' => '退出',
                    'url' => Yii::$app->urlManager->createUrl('man', 'site/logout'),
                    'options' => ['class' => 'navbar-logout']
                ];
            }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>
        <div class="wrap-top">
            <div class="container clear">
                <div class="logo"></div>
                <div class="search">
                    <form method="GET" class="search-form" action="<?=Url::to(['article/search'])?>">
                        <input type="text" name="s" placeholder="输入关键字搜索" autofocus="" x-webkit-speech="" class="search-input" value="<?=Yii::$app->request->getQueryParam('s');?>">
                        <input type="submit" value=" " class="search-submit">
                    </form>
                </div>
                <?php $url = [Yii::$app->controller->id . '/' . Yii::$app->controller->action->id]?>
                <div class="menu">
                    <ul role="tablist" class="clear">
                        <li class="<?= $url == ['site/index'] ? 'active' : ''?>"><a href="<?= Url::to(['site/index'])?>">首页</a></li>
                        <li class="<?= $url == ['article/list'] ? 'active' : ''?>"><a href="<?= Url::to(['article/list'])?>">资讯</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
        <?php /*
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        */
        ?>
        <?= $content ?>
        </div>
        <div class="footer">
            <div style="text-align: center; color: #fff">
                深圳家长会科技有限公司<br />
                全国统一电话：0755-66801780 <br />
                业务联系电话：13088883203<br />
                地址：广东省深圳市南山区前海路1340号前海明珠A304
            </div>
        </div>
    </div> 
    <?php $this->endBody() ?>
    <script src="/js/tab.js"></script>
    <script src="/js/JQUERYCJ.js"></script>
    <script>
        $(function () {
            function initTips() {
                var container = $('.site-index'),
                    tip = $('.float-tip');
                if (container.length > 0)
                    tip.css({top: ($('body').height() - tip.height()) / 2, left: container.offset().left + container.width() + 10}).show();
            };
            $(window).resize(function () {
                initTips();
            });
            initTips();

            jQuery(".banner").slide( {titCell:".small_banner a", mainCell:".items",effect:"left",autoPlay:true} );
        });

    </script>
</body>
</html>
<?php $this->endPage() ?>
