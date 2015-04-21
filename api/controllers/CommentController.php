<?php
namespace api\controllers;

use Yii;
use yii\base\InvalidParamException;
use \backend\modules\hospital\models\Hospital;
use \backend\modules\doctor\models\Doctor;
use \backend\modules\inspection\models\InspectionHospitalMap;
use \backend\modules\operation\models\OperationHospitalMap;
use api\components\MsgHelper;

/**
 * GeneralLedgerController
 */
class CommentController extends BaseController
{
    public $modelClass = 'api\models\Comment';
    protected $loginRequired = true;
    protected $allowGuestActions = ['index'];

    public function actions() {
        $actions = parent::actions();
        unset($actions['update'], $actions['delete'], $actions['create']);
        return $actions;
    }

    public function getQuery() {
        $request = Yii::$app->request;
        $hosp_id = $request->get('hosp_id');
        $_GET['expand'] = 'user';
        $query = parent::getQuery()->andWhere(['t.hosp_id' => $hosp_id])->joinWith('user');
        $arr = ['doctor_id', 'insp_id', 'opera_id'];
        $invalid = true;
        foreach ($arr as $k) {
            $v = $request->get($k);
            if ($v) {
                $query = $query->andWhere(['t.' . $k => $v]);
                $invalid = false;
                break;
            }
        }
        if ($invalid || !$hosp_id)
            throw new InvalidParamException();

        return $query;
    }

    public function actionCreate() {
        $model = new $this->modelClass;
        $model->load(Yii::$app->request->post(), '');
        if (
            empty($model->feedback_manner) || empty($model->feedback_effect) || empty($model->comment) ||
            (!$model->doctor_id && !$model->insp_id && !$model->opera_id) ||
            !$model->hosp_id ||
            !($hosp = Hospital::findOne($model->hosp_id))
        )
            throw new InvalidParamException();

        $sumModel = null;
        if ($model->opera_id)
            $sumModel = OperationHospitalMap::find()->andWhere(['t.hosp_id' => $model->hosp_id, 't.opera_id' => $model->opera_id])->one();
        else if ($model->insp_id)
            $sumModel = InspectionHospitalMap::find()->andWhere(['t.hosp_id' => $model->hosp_id, 't.insp_id' => $model->insp_id])->one();
        else if ($model->doctor_id)
            $sumModel = Doctor::findOne($model->doctor_id);
        if (!$sumModel)
            throw new InvalidParamException();

        $sumModel->feedback_manner_total += $model->feedback_manner;
        $sumModel->feedback_effect_total += $model->feedback_effect;
        $sumModel->feedback_number++;
        $sumModel->feedback_manner = round($sumModel->feedback_manner_total / $sumModel->feedback_number, 2);
        $sumModel->feedback_effect = round($sumModel->feedback_effect_total / $sumModel->feedback_number, 2);

        $tran = Yii::$app->db->beginTransaction();
        if ($sumModel->save() && $model->save()) {
            $tran->commit();
            return $model;
        }
        $tran->rollback();
        return MsgHelper::faile('数据保存出错', $sumModel->getErrors());
    }
}
