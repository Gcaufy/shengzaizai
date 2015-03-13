<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;


/**
 * Site controller
 */
class SiteController extends BaseController
{
    public $modelClass = 'common\models\User';
    protected $loginRequired = false;
}
