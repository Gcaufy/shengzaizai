<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\web\JsExpression;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\hospital\models\Hospital */
/* @var $form yii\widgets\ActiveForm */

$js = "
$('input[name=file]').on('fileuploaded', function(event, data, previewId, index) {
    var response = data.response;
    if (response && response.result && response.result.length === 1) {
        $('#' + $(this).attr('target')).val(response.result[0]);
    }
});

    // 百度地图API功能
    var map = new BMap.Map('allmap');
    var point = new BMap.Point(116.331398,39.897445);
    map.centerAndZoom(point,12);

    //map.enableScrollWheelZoom(true);

    // 添加带有定位的导航控件
    var navigationControl = new BMap.NavigationControl({
        // 靠左上角位置
        anchor: BMAP_ANCHOR_TOP_LEFT,
        // LARGE类型
        type: BMAP_NAVIGATION_CONTROL_LARGE,
        // 启用显示定位
        enableGeolocation: true
    });
    map.addControl(navigationControl);

    // 创建地址解析器实例
    var myGeo = new BMap.Geocoder();
    // 将地址解析结果显示在地图上,并调整地图视野
    $('#hospital-name').change(function () {
        var val = $(this).val();
        myGeo.getPoint(val, function(point){
            if (point) {
                map.centerAndZoom(point, 16);
                map.clearOverlays();
                map.addOverlay(new BMap.Marker(point));
                $('#hospital-longitude').val(point.lng);
                $('#hospital-latitude').val(point.lat);
            } else {
                setTimeout(function () {
                    alert('您选择地址没有解析到结果, 请查询后手动填写经纬度数据');
                    $('#hospital-name').parents('.form-group:eq(0)').addClass('has-error');
                }, 500);
            }
        }, '');
    });

    $('#hospital-latitude, #hospital-longitude').change(function () {
        var lat = $('#hospital-latitude').val(), lng = $('#hospital-longitude').val();
        if (lat && lng) {
            var point = new BMap.Point(lng, lat);
            map.centerAndZoom(point, 16);
            map.clearOverlays();
            map.addOverlay(new BMap.Marker(point));
        }
    });
";
$this->registerJs($js);
?>

<div class="hospital-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => [
            'labelSpan' => ActiveForm::NOT_SET,
            'deviceSize' => ActiveForm::NOT_SET,
            'showLabels' => ActiveForm::SCREEN_READER,
            'showErrors' => false,
            'showHints' => true
        ]
    ]); ?>

    <div class="row" style="margin: 0px;">
        <?= $form->field($model, 'ppic')->initLen(6)->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*', 'name' => 'file', 'target' => 'hospital-pic'],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['/file/upload?folder=hospital']),
                'initialPreview' => $model->pic ? [Html::img("/file?id=" . $model->pic, ['class'=>'file-preview-image'])] : [],
                'initialCaption'=>"已保存图片",
            ]
        ]); ?>

        <?= Html::activeHiddenInput($model, 'pic'); ?>

        <div id="allmap" style="height: 280px;">

        </div>
    </div>




    <?= $form->field($model, 'region_id')->initLen(2)->widget(Select2::classname(), [
        'data' => $regionData,
        'options' => ['placeholder' => '请选择地区'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'name', ['autoPlaceholder' => true])->textInput(['maxlength' => 50])->initLen(6) ?>

    <?= $form->field($model, 'longitude', ['autoPlaceholder' => true])->textInput(['maxlength' => 20])->initLen(2) ?>

    <?= $form->field($model, 'latitude', ['autoPlaceholder' => true])->textInput(['maxlength' => 20])->initLen(2) ?>

    <?= $form->field($model, 'tel', ['autoPlaceholder' => true])->textInput(['maxlength' => 20])->initLen(4) ?>

    <?= $form->field($model, 'addr', ['autoPlaceholder' => true])->textInput(['maxlength' => 200])->initLen(8) ?>

    <?= $form->field($model, 'hot', ['autoPlaceholder' => true])->textInput(['maxlength' => 10])->initLen(2) ?>




    <div class="form-group right">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=yi8EPW0ImqRyqTemE18xtTmn"></script>
