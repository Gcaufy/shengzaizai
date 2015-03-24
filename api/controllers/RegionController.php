<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \common\models\finance\GeneralLedger;

/**
 * GeneralLedgerController
 */
class RegionController extends BaseController
{
    public $modelClass = '\backend\modules\system\models\Region';
    protected $loginRequired = false;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }
    protected function getQuery() {
        $parent_id = Yii::$app->request->get('parent_id');
        $query = parent::getQuery();
        if (!$parent_id)
            $query = $query->andWhere('t.parent_id is null');
        else
            $query = $query->andWhere(['t.parent_id' => $parent_id]);
        return $query;
    }

}
