<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;

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
        $insp_id = Yii::$app->request->get('insp_id');
        if ($hosp_id) {
            $query = $query->joinWith(['detail' => function ($query) use ($hosp_id) {
                return $query->andOnCondition(['detail.hosp_id' => $hosp_id])->andWhere('detail.id is not null');
            }]);
        }
        if ($insp_id) {
            $query->andWhere(['t.id' => $insp_id]);
        }
        return $query;
    }

}
