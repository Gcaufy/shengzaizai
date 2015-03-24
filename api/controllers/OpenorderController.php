<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \backend\modules\operation\models\OperationHospitalMap;

/**
 * GeneralLedgerController
 */
class OpenorderController extends BaseController
{
    public $modelClass = 'api\models\OrderOpen';
    protected $loginRequired = false;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }

    public function getQuery() {
        $hosp_id = Yii::$app->request->get('hosp_id');
        $date = Yii::$app->request->get('date');
        $type = Yii::$app->request->get('type');

        $query = parent::getQuery();
        $arr = ['doctor_id', 'insp_id', 'opera_id'];
        $invalid = true;
        foreach ($arr as $k) {
            $v = Yii::$app->request->get($k);
            if ($v) {
                $query = $query->andWhere(['t.' . $k => $v]);
                $invalid = false;
                break;
            }
        }
        if ($invalid || !$hosp_id)
            throw new InvalidParamException();

        if ($date)
            $query = $query->andWhere(['t.date' => $date]);
        if ($type)
            $query = $query->andWhere(['t.type' => $type]);

        return $query;
    }

}
