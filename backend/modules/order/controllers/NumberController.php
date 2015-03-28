<?php

namespace backend\modules\order\controllers;

use Yii;
use backend\modules\hospital\models\Hospital;
use backend\modules\doctor\models\Doctor;
use backend\modules\inspection\models\Inspection;
use backend\modules\operation\models\Operation;
use backend\modules\order\models\Order;
use backend\modules\order\models\Number;
use backend\modules\order\models\NumberSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NumberController implements the CRUD actions for Number model.
 */
class NumberController extends \backend\controllers\ShiroController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Number models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $ptype = $request->getQueryParam('ptype');
        $pid = $request->getQueryParam('pid');
        $hosp_id = $request->getQueryParam('hosp_id');

        $hospital = null;
        $doctor = null;
        $inspection = null;
        $operation = null;
        if ($hosp_id && $ptype && $pid) {
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
            switch ($ptype) {
                case Order::TYPE_DOCTOR:
                    $doctor = Doctor::find()->andWhere(['t.id' => $pid])->one();
                    break;
                case Order::TYPE_INSPECTION:
                    $inspection = Inspection::find()->andWhere(['t.id' => $pid])->one();
                    break;
                case Order::TYPE_OPERATION:
                    $operation = Operation::find()->andWhere(['t.id' => $pid])->one();
                    break;
            }
        }

        $searchModel = new NumberSearch();
        $searchModel->load($request->queryParams);
        $dataProvider = $searchModel->search(NumberSearch::buildQuery($ptype, $pid, $hosp_id));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ptype' => $ptype,
            'pid' => $pid,
            'hosp_id' => $hosp_id,
            'hospital' => $hospital,
            'doctor' => $doctor,
            'inspection' => $inspection,
            'operation' => $operation,
        ]);
    }

    /**
     * Displays a single Number model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $ptype = $request->getQueryParam('ptype');
        $pid = $request->getQueryParam('pid');
        $hosp_id = $request->getQueryParam('hosp_id');
        $hospital = null;
        $doctor = null;
        $inspection = null;
        $operation = null;
        if ($hosp_id && $ptype && $pid) {
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
            switch ($ptype) {
                case Order::TYPE_DOCTOR:
                    $doctor = Doctor::find()->andWhere(['t.id' => $pid])->one();
                    break;
                case Order::TYPE_INSPECTION:
                    $inspection = Inspection::find()->andWhere(['t.id' => $pid])->one();
                    break;
                case Order::TYPE_OPERATION:
                    $operation = Operation::find()->andWhere(['t.id' => $pid])->one();
                    break;
            }
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'ptype' => $ptype,
            'pid' => $pid,
            'hosp_id' => $hosp_id,
            'hospital' => $hospital,
            'doctor' => $doctor,
            'inspection' => $inspection,
            'operation' => $operation,
        ]);
    }

    /**
     * Creates a new Number model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $ptype = $request->getQueryParam('ptype');
        $pid = $request->getQueryParam('pid');
        $hosp_id = $request->getQueryParam('hosp_id');
        $hospital = null;
        $doctor = null;
        $inspection = null;
        $operation = null;

        if ($hosp_id && $ptype && $pid) {
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
            switch ($ptype) {
                case Order::TYPE_DOCTOR:
                    $doctor = Doctor::find()->andWhere(['t.id' => $pid])->one();
                    break;
                case Order::TYPE_INSPECTION:
                    $inspection = Inspection::find()->andWhere(['t.id' => $pid])->one();
                    break;
                case Order::TYPE_OPERATION:
                    $operation = Operation::find()->andWhere(['t.id' => $pid])->one();
                    break;
            }
        }

        $model = new Number();
        if ($ptype && $pid && $hosp_id) {
            $keyMap = Order::getTypeKeyMap();
            $key = $keyMap[$ptype];
            $model->$key = $pid;
            $model->hosp_id = $hosp_id;
        }
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->active_order_num)
                $model->active_order_num = $model->order_num;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '创建成功.');
                if ($ptype)
                    return $this->redirect(['view',
                        'id' => $model->id,
                        'ptype' => $ptype,
                        'pid' => $pid,
                        'hosp_id' => $hosp_id,
                    ]);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                var_dump($model->getErrors());exit;
                Yii::$app->session->setFlash('error', '创建失败.');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'ptype' => $ptype,
            'pid' => $pid,
            'hosp_id' => $hosp_id,
            'hospital' => $hospital,
            'doctor' => $doctor,
            'inspection' => $inspection,
            'operation' => $operation,
        ]);
    }

    /**
     * Updates an existing Number model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $ptype = $request->getQueryParam('ptype');
        $pid = $request->getQueryParam('pid');
        $hosp_id = $request->getQueryParam('hosp_id');
        $hospital = null;
        $doctor = null;
        $inspection = null;
        $operation = null;

        if ($hosp_id && $ptype && $pid) {
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
            switch ($ptype) {
                case Order::TYPE_DOCTOR:
                    $doctor = Doctor::find()->andWhere(['t.id' => $pid])->one();
                    break;
                case Order::TYPE_INSPECTION:
                    $inspection = Inspection::find()->andWhere(['t.id' => $pid])->one();
                    break;
                case Order::TYPE_OPERATION:
                    $operation = Operation::find()->andWhere(['t.id' => $pid])->one();
                    break;
            }
        }


        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '更新成功.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', '更新失败.');
            }
        }
        return $this->render('update', [
            'model' => $model,
            'ptype' => $ptype,
            'pid' => $pid,
            'hosp_id' => $hosp_id,
            'hospital' => $hospital,
            'doctor' => $doctor,
            'inspection' => $inspection,
            'operation' => $operation,
        ]);
    }

    /**
     * Deletes an existing Number model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Number model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id

     * @return Number the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Number::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

