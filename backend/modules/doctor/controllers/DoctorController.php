<?php

namespace backend\modules\doctor\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\modules\hospital\models\Hospital;
use backend\modules\doctor\models\Doctor;
use backend\modules\doctor\models\DoctorSearch;
use backend\modules\order\models\NumberSearch;
use backend\controllers\ShiroController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DoctorController implements the CRUD actions for Doctor model.
 */
class DoctorController extends ShiroController
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
     * Lists all Doctor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DoctorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Doctor models.
     * @return mixed
     */
    public function actionOum($id)
    {
        $p = Yii::$app->request->queryParams;
        if (!isset($p['NumberSearch']))
            $p['NumberSearch'] = [];
        $p['NumberSearch']['doctor_id'] = $id;

        $searchModel = new NumberSearch();
        $dataProvider = $searchModel->search();

        return $this->render('oum', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Doctor model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $hospital = null;
        $hosp_id = Yii::$app->request->getQueryParam('hosp_id');
        if ($hosp_id) {
            $model->hosp_id = $hosp_id;
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
        }
        return $this->render('view', [
            'model' => $model,
            'hospital' => $hospital,
        ]);
    }

    /**
     * Creates a new Doctor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $hosp_id = Yii::$app->request->getQueryParam('hosp_id');
        $model = new Doctor();
        $hospital = null;
        if ($hosp_id) {
            $model->hosp_id = $hosp_id;
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '创建成功.');
                return $this->redirect(['view', 'id' => $model->id, 'hosp_id' => $hosp_id]);
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
     * Updates an existing Doctor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $hospital = null;
        $hosp_id = Yii::$app->request->getQueryParam('hosp_id');
        if ($hosp_id) {
            $model->hosp_id = $hosp_id;
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '更新成功.');
                return $this->redirect(['view', 'id' => $model->id, 'hosp_id' => $hosp_id]);
            } else {
                Yii::$app->session->setFlash('error', '更新失败.');
            }
        }
        return $this->render('update', [
            'model' => $model,
            'hospital' => $hospital,
        ]);
    }

    /**
     * Deletes an existing Doctor model.
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
     * Finds the Doctor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Doctor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Doctor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
