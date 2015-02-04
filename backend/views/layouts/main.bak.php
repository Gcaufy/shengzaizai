<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\BootstrapPluginAsset;

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
<?= Html::encode($this->title) ?>
<?php $appuser = Yii::$app->user;?>
<?php $usermodel = $appuser->identity;?>
</title>
<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
        $unReadNote = false;
        $unReadMessage = false;
        $unReadHomework = false;
        if (!Yii::$app->user->isGuest) {
            $unReadNote = Note::find()->joinWith('unReadNote')->count('DISTINCT `t`.`id`');
        }


        NavBar::begin([
            'brandLabel' => '蜜蜂家长会',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => '首页', 'url' => Yii::$app->urlManager->createUrl('www', '/')],
            ['label' => '消息' . ($unReadMessage ? "($unReadNote)" : ''), 'url' => ['/message/feedback/index']],
            ['label' => '通知' . ($unReadNote ? "($unReadNote)" : ''), 'url' => ['/message/note/index']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
        } else {
            $menuItems[] = [
                'label' => Yii::t('app','退出').' (' . Yii::$app->user->identity->displayName . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    ?>
    <div class="container">
        <div class="left col-md-3 col-sm-4">
            <div class="list-group" id="accordion">
            <?php
            if (!empty(Yii::$app->params['rules'])) {
                $cururl = $this->context->module->id . '/' . Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
                foreach (Yii::$app->params['rules'] as $k => $v) {
                    $collapse = 'collapsed';
                    $expand = '';
                    if ($v['m'] == $this->context->module->id) {
                        $collapse = '';
                        $expand = 'in';
                    }
                    if (Yii::$app->user->can("menu.{$v['m']}.view")) {
                        echo '<div class="panel panel-default"><a class="list-group-item '.$collapse.'" href="#m'.$k.'" data-toggle="collapse" data-parent="#accordion">'.(isset($v['i']) ? '<i class="'.$v['i'].'"></i> ' : '').Yii::t('app',$v['n']).'<span class="fa fa-chevron-right"></span></a><div id="m'.$k.'" class="submenu panel-collapse collapse '.$expand.'">';
                        foreach ($v['s'] as $kk=>$vv) {
                            if (Yii::$app->user->can('menu.' . $v['m'] . '.' . $vv['c'] . '.' . $vv['m'] . '.view')) {
                                $url = $v['m'].'/'.$vv['c'].'/'.$vv['m'];
                                $active = '';
                                if($url==$cururl){
                                    $active = ' active';
                                }
                                echo Html::a((isset($vv['i']) ? '<i class="'.$vv['i'].'"></i> ' : '').Yii::t('app',$vv['n']), ['/'.$url], ['class' => 'list-group-item'.$active]);
                            }
                        }
                        echo '</div></div>';
                    }
                }
            }
            ?>
            </div>
        </div>
        <div class="right col-md-9 col-sm-8">
            <?= $content ?>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="text-muted">©copyright 2014 深圳家长会科技有限公司 csgb.net 版权所有 站长统计</p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
