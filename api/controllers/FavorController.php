<?php
namespace api\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use api\components\MsgHelper;

/**
 * FavorController
 */
class FavorController extends BaseController
{
    public $modelClass = 'api\models\Favor';
    protected $loginRequired = true;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }


    public function actionCreate() {
        $model = new $this->modelClass;
        $params = ['article_id', 'doctor_id', 'hosp_id', 'insp_id', 'opera_id'];
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $status = false;
        $query = $model::find()->me();
        foreach ($params as $col) {
            if ($model->$col) {
                $status = true;
                $query->andWhere(['t.' . $col => $model->$col]);
            }
        }
        if (!$status)
            throw new NotFoundHttpException("参数错误", 1);

        if ($query->one()) {
            return MsgHelper::faile('请勿重复收藏.');
        }
        if ($model->save())
            return MsgHelper::success('收藏成功.');
        else
            return MsgHelper::faile('收藏失败', $model->getErrors());
    }


    protected function getQuery() {
        $expand = Yii::$app->request->get('expand');
        $query = parent::getQuery()->me();
        switch ($expand) {
            case 'article':
                $query = $query->joinWith($expand)->andWhere('t.article_id is not null');
                break;
            case 'doctor':
                $query = $query->joinWith($expand)->andWhere('t.doctor_id is not null');
                break;
            case 'inspection':
                $query = $query->joinWith($expand)->andWhere('t.insp_id is not null');
                break;
            case 'operation':
                $query = $query->joinWith($expand)->andWhere('t.opera_id is not null');
                break;
            case 'hospital':
                $query = $query->joinWith($expand)->andWhere('t.hosp_id is not null and t.doctor_id is null and t.opera_id is null and t.insp_id is null');
                break;
        }
        return $query;
    }
}
