<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \backend\modules\inspection\models\InspectionHospitalMap;

/**
 * GeneralLedgerController
 */
class InspectionController extends BaseController
{
    public $modelClass = 'api\models\Inspection';
    protected $loginRequired = false;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }

    public function getQuery() {
        $query = parent::getQuery();
        $hosp_id = Yii::$app->request->get('hosp_id');
        if ($hosp_id) {
            $rst = InspectionHospitalMap::find()->andWhere(['t.hosp_id' => $hosp_id])->select('t.insp_id')->asArray()->all();
            $arr = [];
            foreach ($rst as $key => $value) {
                $arr[] = $value['insp_id'];
            }
            $query = $query->andWhere(['t.id' => $arr]);
        }
        return $query;
    }

}
