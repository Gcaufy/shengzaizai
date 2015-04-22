<?php
namespace api\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use \backend\modules\operation\models\OperationHospitalMap;
use api\models\OrderOpen;
use api\models\Order;
use api\models\Hospital;
use api\components\MsgHelper;


/**
 * GeneralLedgerController
 */
class OrderController extends BaseController
{
    public $modelClass = 'api\models\Order';
    protected $loginRequired = true;

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['create']);
        return $actions;
    }

    public function getQuery() {
        $query = parent::getQuery();
        return $query->andWhere(['t.cid' => Yii::$app->user->identity->id]);
    }

    public function actionCancel($id) {
        if (!$id || !($model = $this->getQuery()->andWhere(['t.id' => $id, 't.cid' => Yii::$app->user->identity->id])->one()))
            throw new NotFoundHttpException("数据不存在: $id");
        if (!$model->start_time)
            $model->start_time = '00:00:00';
        $starttime = strtotime($model->date . ' ' . $model->start_time);
        // Can not cancle the order whichis in 12 hours
        if ($starttime - time() < 60 * 60 * 12) {
            return MsgHelper::faile('12小时内的订单无法取消.');
        }
        if ($model->delete())
            return MsgHelper::success('取消订单成功.');
        else
            return MsgHelper::faile('取消订单失败.', $model->getErrors());
    }


    public function actionCreate() {
        $openorderId = isset($_POST['openorder_id']) ? $_POST['openorder_id'] : null;
        $doctorId = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : null;

        if (!$openorderId)
            throw new NotFoundHttpException("数据不存在: $id");

        $rst = Order::createOrder($openorderId, $doctorId);
        if ($rst instanceof Order)
            return $rst;

        if ($rst === Order::ERROR_NO_ACTIVE_NUM)
            return MsgHelper::faile('预约号已用完.');
        if ($rst === Order::ERROR_EXISTS)
            return MsgHelper::faile('已成功预约此项, 请勿重复预约.');
        return MsgHelper::faile('数据有误, 请联系管理员.');
    }

    public function actionInstruction($id) {
        $instruction = Yii::$app->getRequest()->getBodyParam('instruction');
        $diagnosis = Yii::$app->getRequest()->getBodyParam('diagnosis');
        if (!$id || !$instruction || !($model = Order::find()->andWhere(['t.cid' => Yii::$app->user->identity->id, 't.id' => $id])->one()))
            throw new NotFoundHttpException("参数有误");
        $model->instruction = $instruction;
        $model->diagnosis = $diagnosis;
        if ($model->save()) {
            return MsgHelper::success('医嘱更新成功.');
        } else {
            return MsgHelper::faile('数据有误, 请联系管理员.', $model->getErrors());
        }
    }
}
