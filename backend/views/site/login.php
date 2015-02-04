<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="container">

<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-signin']]); ?>
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">登陆</h1>
        </div>
        <div class="login-wrap">
            <?= $form->field($model, 'mobile')->textInput(['placeholder' => '请输入手机号登陆！'])->label('') ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入您的用户密码！'])->label('') ?>
            <?= Html::submitButton('<i class="fa fa-check"></i>', ['class' => 'btn btn-lg btn-login btn-block', 'name' => 'login-button']) ?>


            <div class="registration">
                还未注册?
                <a class="" href="registration.html">
                    注册
                </a>
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> 记住我
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> 忘记密码?</a>

                </span>
            </label>
        </div>
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">忘记密码 ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>输入绑定邮箱重置密码.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
                        <button class="btn btn-primary" type="button">提交</button>
                    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
