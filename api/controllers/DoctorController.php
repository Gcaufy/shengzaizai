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
    public $modelClass = 'api\models\Doctor';
    protected $loginRequired = false;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }

    protected function getQuery() {
        $_GET['expand'] = 'tag,title';
        $query = parent::getQuery()->joinWith(['tag.tag', 'title.title']);
        return $query;
    }
}
