<?php

namespace backend\modules\hospital\controllers;

use Yii;
use backend\modules\hospital\models\Hospital;
use backend\modules\hospital\models\HospitalSearch;
use backend\modules\doctor\models\Doctor;
use backend\modules\system\models\Region;

use backend\modules\doctor\models\DoctorSearch;
use backend\modules\inspection\models\InspectionHospitalMapSearch;
use backend\modules\operation\models\OperationHospitalMapSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HospitalController implements the CRUD actions for Hospital model.
 */
class HospitalController extends Controller
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
     * Lists all Hospital models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HospitalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Hospital model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {

        $p = Yii::$app->request->queryParams;
        if (!isset($p['DoctorSearch']))
            $p['DoctorSearch'] = [];
        $p['DoctorSearch']['hosp_id'] = $id;

        if (!isset($p['InspectionHospitalMap']))
            $p['InspectionHospitalMap'] = [];
        $p['InspectionHospitalMap']['hosp_id'] = $id;


        if (!isset($p['OperationHospitalMap']))
            $p['OperationHospitalMap'] = [];
        $p['OperationHospitalMap']['hosp_id'] = $id;



        $searchDoctor = new DoctorSearch();
        $doctorProvider = $searchDoctor->search($p);
        $searchInsp = new InspectionHospitalMapSearch();
        $inspProvider = $searchInsp->search($p);
        $searchOpera = new OperationHospitalMapSearch();
        $operaProvider = $searchOpera->search($p);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'doctorProvider' => $doctorProvider,
            'searchDoctor' => $searchDoctor,
            'inspProvider' => $inspProvider,
            'searchInsp' => $searchInsp,
            'operaProvider' => $operaProvider,
            'searchOpera' => $searchOpera,
        ]);
    }

    /**
     * Creates a new Hospital model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Hospital();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '创建成功.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', '创建失败.');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'regionData' => $this->getRegion(),
        ]);
    }

    /**
     * Updates an existing Hospital model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '更新成功.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', '更新失败.');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'regionData' => $this->getRegion(),
        ]);
    }

    /**
     * Deletes an existing Hospital model.
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
     * Finds the Hospital model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Hospital the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hospital::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getRegion() {
        $arr = Region::find()->joinWith('children')->andWhere('t.parent_id is null')->asArray()->all();
        foreach ($arr as $item) {
            $row = [];
            $carr = $item['children'];
            $children = [];
            if ($carr) {
                foreach ($carr as $citem) {
                    $children[$citem['id']] = $citem['name'];
                }
                $row[$item['name']] = $children;
            }
            $rst[] = $row;
        }
        return $rst;
    }
}
