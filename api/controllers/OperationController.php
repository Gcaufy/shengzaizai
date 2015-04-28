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
class OperationController extends BaseController
{
    public $modelClass = 'api\models\Operation';
    protected $loginRequired = false;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }


    public function getQuery() {
        $query = parent::getQuery();
        $hosp_id = Yii::$app->request->get('hosp_id');
        $opera_id = Yii::$app->request->get('opera_id');
        if ($hosp_id) {
            $query = $query->joinWith(['detail' => function ($query) use ($hosp_id) {
                return $query->andOnCondition(['detail.hosp_id' => $hosp_id])->andWhere('detail.id is not null');
            }]);
        }
        if ($opera_id) {
            $query->andWhere(['t.id' => $opera_id]);
        }
        return $query;
    }
}
