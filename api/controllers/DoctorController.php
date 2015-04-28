<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \backend\modules\doctor\models\DoctorOperaMap;

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
        $query = parent::getQuery()->joinWith(['hospital', 'tag.tag', 'title.title']);
        $opera_id = Yii::$app->request->get('opera_id');
        if ($opera_id) {
            $rst = DoctorOperaMap::find()->andWhere(['t.opera_id' => $opera_id])->select('t.doctor_id')->asArray()->all();
            $arr = [];
            foreach ($rst as $key => $value) {
                $arr[] = $value['doctor_id'];
            }
            $query = $query->andWhere(['t.id' => $arr]);
        }
        return $query;
    }
}
