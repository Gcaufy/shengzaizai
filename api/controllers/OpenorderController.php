<?php
namespace api\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \backend\modules\operation\models\OperationHospitalMap;


/**
 * GeneralLedgerController
 */
class OpenorderController extends BaseController
{
    public $modelClass = 'api\models\OrderOpen';
    protected $loginRequired = false;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }

    protected function getQuery() {
        $hosp_id = Yii::$app->request->get('hosp_id');
        $date = Yii::$app->request->get('date');
        $isvip = Yii::$app->request->get('isvip');
        $month = Yii::$app->request->get('month');
        $year = Yii::$app->request->get('year');
        $year = date('Y');

        $query = parent::getQuery()->andWhere(['t.hosp_id' => $hosp_id]);
        $arr = ['doctor_id', 'insp_id', 'opera_id'];
        $invalid = true;
        foreach ($arr as $k) {
            $v = Yii::$app->request->get($k);
            if ($v) {
                $query = $query->andWhere(['t.' . $k => $v]);
                $invalid = false;
                break;
            }
        }
        if ($invalid || !$hosp_id)
            throw new InvalidParamException();

        if ($month && $year)
            $query = $query->andWhere(['SUBSTR(t.date, 1, 4)' => $year, 'SUBSTR(t.date, 6, 2)' => [$month + 1, $month + 2]]);

        if ($date)
            $query = $query->andWhere(['t.date' => $date]);
        if ($isvip)
            $query = $query->andWhere(['t.isvip' => $isvip]);

        return $query->andWhere('t.active_order_num > 0');
    }

    public function actionCurrentweek() {
        $query = $this->getQuery();
        $date = date('Y-m-d');
        $query->select([
                'order_num' => 'sum(t.order_num)',
                'active_order_num' => 'sum(t.active_order_num)',
                'date',
                'isvip',
                'cost',
                'week' => 'WEEKDAY(t.date)',
            ])
            ->andWhere("DATEDIFF(t.date, '$date') > 0 and DATEDIFF(date, '$date') < 8")
            ->groupBy('t.date')
            ->orderBy('t.date desc');
        $rst = $query->asArray()->all();
        return $rst;
    }

    public function actionCurrentmonth() {
        $query = $this->getQuery();
        $month = date('m');
        $year = date('Y');
        $date = date('Y-m-d');
        $query->select([
                'order_num' => 'sum(t.order_num)',
                'active_order_num' => 'sum(t.active_order_num)',
                'cost',
                'month' => 'SUBSTR(t.date, 6, 2)',
            ])
            ->andWhere("SUBSTR(t.date, 1, 4) = $year and DATEDIFF(t.date, '$date') > 0 and SUBSTR(t.date, 6, 2) <= $month + 1")
            ->groupBy('month')
            ->orderBy('month desc');
        $rst = $query->asArray()->all();
        return $rst;
    }

}
