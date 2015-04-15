<?php

namespace backend\modules\operation\controllers;

use Yii;
use backend\modules\hospital\models\Hospital;
use backend\modules\operation\models\OperationHospitalMap;
use backend\modules\operation\models\OperationHospitalMapSearch;
use backend\controllers\ShiroController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HospitalController implements the CRUD actions for OperationHospitalMap model.
 */
class HospitalController extends ShiroController
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
     * Lists all OperationHospitalMap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OperationHospitalMapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OperationHospitalMap model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $hosp_id = Yii::$app->request->get('hosp_id');
        $hospital = null;
        if ($hosp_id) {
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'hospital' => $hospital,
        ]);
    }

    /**
     * Creates a new OperationHospitalMap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OperationHospitalMap();
        $hosp_id = Yii::$app->request->get('hosp_id');
        $hospital = null;
        if ($hosp_id) {
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
            $model->hosp_id = $hosp_id;
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '创建成功.');
                $param = ['view', 'id' => $model->id];
                if ($hospital)
                    $param['hosp_id'] = $hospital->id;
                return $this->redirect($param);
            } else {
                Yii::$app->session->setFlash('error', '创建失败.');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'hospital' => $hospital,
        ]);
    }

    /**
     * Updates an existing OperationHospitalMap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $hosp_id = Yii::$app->request->get('hosp_id');
        $hospital = null;
        if ($hosp_id) {
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
            $model->hosp_id = $hosp_id;
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '更新成功.');
                $param = ['view', 'id' => $model->id];
                if ($hospital)
                    $param['hosp_id'] = $hospital->id;
                return $this->redirect($param);
            } else {
                Yii::$app->session->setFlash('error', '更新失败.');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'hospital' => $hospital,
        ]);
    }

    /**
     * Deletes an existing OperationHospitalMap model.
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
     * Finds the OperationHospitalMap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return OperationHospitalMap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OperationHospitalMap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
