<?php

use yii\helpers\Html;
use backend\components\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\system\models\Region */
/* @var $form yii\widgets\ActiveForm */

$js = "
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
    $('#region-name').change(function () {
        var val = $(this).val();
        myGeo.getPoint(val, function(point){
            if (point) {
                map.centerAndZoom(point, 16);
                map.clearOverlays();
                map.addOverlay(new BMap.Marker(point));
                $('#region-longitude').val(point.lng);
                $('#region-latitude').val(point.lat);
            } else {
                setTimeout(function () {
                    $('#region-name').next().html('您选择地址没有解析到结果, 请查询后手动填写经纬度数据').parents('.form-group:eq(0)').addClass('has-error');
                }, 500);
            }
        }, '');
    });

    $('#region-latitude, #region-longitude').change(function () {
        var lat = $('#region-latitude').val(), lng = $('#region-longitude').val();
        if (lat && lng) {
            var point = new BMap.Point(lng, lat);
            map.centerAndZoom(point, 16);
            map.clearOverlays();
            map.addOverlay(new BMap.Marker(point));
        }
    });
";
$this->registerJs($js);


$option = ['placeholder' => '顶级项目', 'value' => '0'];
if (!$model->isNewRecord)
    $option['disabled'] = 'disabled';
?>

<style type="text/css">
    #allmap {width: 100%;height: 300px;overflow: hidden;}
</style>

    <div class="col-lg-6">
        <section class="panel">
            <div class="panel-body">
                <div class="region-form">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'parent_id')->ajaxSelect(Url::to('regionsearch'), ['options' => $option]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => 10, 'placeholder' => '输入地区名将自动解析经纬度']) ?>

                    <?= $form->field($model, 'longitude')->textInput(['maxlength' => 20]) ?>

                    <?= $form->field($model, 'latitude')->textInput(['maxlength' => 20]) ?>

                    <div class="form-group right">
                        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </section>
    </div>
    <div class="col-lg-6">
        <section class="panel">
            <div class="panel-body">
                <div id="allmap"></div>
            </div>
        </section>
    </div>




<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=yi8EPW0ImqRyqTemE18xtTmn"></script>
