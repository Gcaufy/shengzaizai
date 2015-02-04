<?php

use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
$this->registerJsFile('/dialog/jquery.artDialog.js?skin=idialog', ['depends'=>[BootstrapPluginAsset::className()]]);
$this->registerJsFile('/dialog/plugins/iframeTools.js', ['depends'=>[BootstrapPluginAsset::className()]]);

$this->title = Yii::t('app','文件上传');
?>
<div class="upload-index">
	<?= FileInput::widget([
	    'name' => 'file',
	    'options'=>['accept' => 'image/*'],
	    'pluginOptions' => [
	        'previewFileType'=>'image',
	        'showCaption'=>false,
	    	'maxFileCount'=>1,
	    	'dropZoneTitle'=>'请拖动图片到这里',
	    	'uploadUrl'=> Url::to(['/upload/image']),
	    ],
	    'pluginEvents'=>[
	    	'fileuploaded'=>'function(event, formdata, preview, index, data) {if(data.ok){$(this).attr("value",data.fpath);$(".file-caption-name").html(\'<span class="glyphicon glyphicon-file kv-caption-icon"></span>\'+data.fpath); art.dialog.data("returl",data.domain+data.fpath);}}',
	    ],
	]);?>
</div>
