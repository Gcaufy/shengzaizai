<?php
use frontend\assets\StaticAsset;
use frontend\assets\StaticIEAsset;

StaticAsset::register($this);
StaticIEAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html>
<head>
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <title>蜜蜂家长会</title>
    <meta name="description" content="A free responsive HTML 5 template with a clean style.">
    <meta name="keywords" content="free template, html 5, responsive, clean, scss">
    <link rel="apple-touch-icon" href="/images/touch/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/touch/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/touch/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/touch/apple-touch-icon-144x144.png">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <!--[if lt IE 9]>
        <script src="js/html5.js"></script>
        <script src="js/respond.js"></script>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body class="no-js">
<div class="main">
    <header>
        <div class="wrap">
            <img src="/images/iphone.png" height="532" width="252" alt="" class="header-img">
            <div class="header-wrapper">
                <h1>东半球最好用的家校互动平台<span></span></h1>
                <p>改变传统教育中所有低效的家校沟通方式</p>
                <p>移动互联网与大数据连接家与学校的一切</p>
                <p class="autor"><a href="javascript: void();">  </a> </p>
                <div class="buttons-wrapper">
                        <a href="javascript: void();" class="button button-download">
                            <span class="button-download-title">下载软件 </span>
                            <span class="button-download-subtitle">iPhone版</span></a>
                            <a href="javascript: void();" class="button button-download android">
                            <span class="button-download-title">下载软件</span>
                            <span class="button-download-subtitle">Android版</span>
                        </a>
                    <a href="<?= Yii::$app->urlManager->createUrl('man', ['site/login']); ?>" class="button button-stripe">登录平台</a>
                </div>
            </div>
            <!-- /.header-wrapper -->
        </div>
        <!-- /.wrap -->
    </header>
    <body>
        <?php $this->beginBody() ?>
        <?= $content ?>
        <?php $this->endBody() ?>
    </body>
    <footer>
        <div class="wrap">
            <img src="/images/logo.jpg" width="120" height="120">
            <p>Copyright &copy; 2014 - 2015<strong> www.imnbee.com</strong>, All Rights Reserved .深圳家长会科技有限公司</p>
            <p><a href="http://www.miitbeian.gov.cn/" title="工信部" target="_blank">粤ICP备15009102号-1</a></p>
        </div>
    <!-- /.wrap -->
    </footer>
    </body>
</html>
<?php $this->endPage() ?>
