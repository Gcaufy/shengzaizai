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
class DoctorController extends BaseController
{
    public $modelClass = '\backend\modules\doctor\models\Doctor';
    protected $loginRequired = false;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }

    protected function getQuery() {
        $query = parent::getQuery()->joinWith(['doctorTagMap.tag', 'doctorTitleMap.title']);
        return $query;
    }

    public function actionAll() {
        $query = parent::getQuery()->joinWith(['doctorTagMap.tag', 'doctorTitleMap.title']);
        return $query->asArray()->all();
    }
}
