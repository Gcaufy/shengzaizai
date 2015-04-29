<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \backend\modules\inspection\models\Inspection;
use \backend\modules\operation\models\Operation;
use \backend\modules\inspection\models\InspectionHospitalMap;
use \backend\modules\operation\models\OperationHospitalMap;

/**
 * GeneralLedgerController
 */
class HospitalController extends BaseController
{
    public $modelClass = 'api\models\Hospital';
    protected $loginRequired = false;


    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }

    public function actionInspection($hosp_id) {
        return InspectionHospitalMap::find()->joinWith('insp')->andWhere(['hosp_id' => $hosp_id])->asArray()->all();
    }
    public function actionOperation($hosp_id) {
        return OperationHospitalMap::find()->joinWith('opera')->andWhere(['hosp_id' => $hosp_id])->asArray()->all();
    }

    protected function getQuery() {
        $model = new $this->modelClass;
        $a = $model->attributes();
        $a = $model::getTableSchema()->columns;
        $query = parent::getQuery();
        $latitude = isset($_GET['latitude']) ? $_GET['latitude'] : null;
        $longitude = isset($_GET['longitude']) ? $_GET['longitude'] : null;
        $longitude = isset($_GET['longitude']) ? $_GET['longitude'] : null;
        $opera_id = Yii::$app->request->get('opera_id');
        $insp_id = Yii::$app->request->get('insp_id');
        $rst = [];
        $arr = [];
        if ($opera_id) {
            $rst = OperationHospitalMap::find()->select('hosp_id')->andWhere(['t.opera_id' => $opera_id])->asArray()->all();
        } else if ($insp_id) {
            $rst = InspectionHospitalMap::find()->select('hosp_id')->andWhere(['t.insp_id' => $insp_id])->asArray()->all();
        }
        $arr = [];
        foreach ($rst as $key => $value) {
            $arr[] = $value['hosp_id'];
        }
        if ($arr)
            $query->andWhere(['t.id' => $arr]);
        if ($latitude && $longitude)
            $query->addSelect(['t.*', 'distance' => "round(6378.138*2*asin(sqrt(pow(sin( ($latitude*pi()/180-t.latitude*pi()/180)/2),2)+cos($latitude*pi()/180)*cos(t.latitude*pi()/180)* pow(sin( ($longitude*pi()/180-t.longitude*pi()/180)/2),2)))*1000)"]);
        return $query;
    }

    // Not Used
    protected function getdistance($lng1,$lat1,$lng2,$lat2){
        //将角度转为狐度
        $radLat1=deg2rad($lat1);//deg2rad()函数将角度转换为弧度
        $radLat2=deg2rad($lat2);
        $radLng1=deg2rad($lng1);
        $radLng2=deg2rad($lng2);
        $a=$radLat1-$radLat2;
        $b=$radLng1-$radLng2;
        $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137*1000;
        return $s;
    }

    //第一点经纬度： lng1 lat1
    //第二点经纬度： lng2 lat2
    //round(6378.138*2*asin(sqrt(pow(sin( (lat1*pi()/180-lat2*pi()/180)/2),2)+cos(lat1*pi()/180)*cos(lat2*pi()/180)* pow(sin( (lng1*pi()/180-lng2*pi()/180)/2),2)))*1000)


}
