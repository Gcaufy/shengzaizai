<?php
namespace api\controllers;

use Yii;

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
}
