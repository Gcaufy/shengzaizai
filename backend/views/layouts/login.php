<?php
use backend\assets\LoginAsset;

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<html>
<!DOCTYPE html>
<html lang="cn" class="no-js">
    <head>
        <meta charset="utf-8">
        <title>蜜蜂家长会登录页面</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- CSS -->
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?= $content ?>
        <?php $this->endBody() ?>
        <!-- Javascript -->
        <!--script src="assets/js/supersized.3.2.7.min.js" ></script>
        <script src="assets/js/supersized-init.js" ></script>
        <script src="assets/js/scripts.js" ></script-->
    </body>
</html>
<?php $this->endPage() ?>
