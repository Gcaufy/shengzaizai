<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use api\models\Category;
use api\models\Article;

/**
 * Site controller
 */
class ArticleController extends BaseController
{
    public $modelClass = 'api\models\Article';
    protected $loginRequired = false;

    public function actionCategory() {
        return Category::find()->all();
    }

    public function actionAll() {
        return Category::find()->joinWith('articles')->asArray()->all();
    }
}
