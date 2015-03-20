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
class OperationController extends BaseController
{
    public $modelClass = '\backend\modules\operation\models\Operation';
    protected $loginRequired = false;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }
}
