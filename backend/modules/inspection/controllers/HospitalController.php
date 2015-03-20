<?php

namespace backend\modules\inspection\controllers;

use Yii;
use yii\helpers\Json;
use backend\modules\hospital\models\Hospital;
use backend\modules\inspection\models\InspectionHospitalMap;
use backend\modules\inspection\models\InspectionHospitalMapSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\ShiroController;
use backend\modules\inspection\models\Inspection;

/**
 * HospitalController implements the CRUD actions for InspectionHospitalMap model.
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
     * Lists all InspectionHospitalMap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InspectionHospitalMapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InspectionHospitalMap model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InspectionHospitalMap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InspectionHospitalMap();
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
        ]);
    }

    /**
     * Updates an existing InspectionHospitalMap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $request = Yii::$app->request;
        $hosp_id = $request->getQueryParam('hosp_id');
        $insp_id = $request->getQueryParam('insp_id');
        $inspection = Inspection::findOne($insp_id);
        $hospital = Hospital::findOne($hosp_id);
        $isAjax = Yii::$app->request->isAjax;

        if (!$inspection || !$hospital)
            $this->throwNotFound();

        $model = InspectionHospitalMap::find()->andWhere(['hosp_id' => $hosp_id, 'insp_id' => $insp_id])->one();
        if (!$model) {
            $parent = InspectionHospitalMap::find()->andWhere(['hosp_id' => $hosp_id, 'insp_id' => $inspection->parent_id])->one();
            if (!$parent) {
                $parent = new InspectionHospitalMap();
                $parent->hosp_id = $hosp_id;
                $parent->insp_id = $inspection->parent_id;
                $parent->save();
            }
            $model = new InspectionHospitalMap();
            $model->hosp_id = $hosp_id;
            $model->insp_id = $insp_id;
            $model->save();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '更新成功.');
                if ($isAjax)
                    return '更新成功';
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', '更新失败.');
            }
        }
        if ($isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
                'inspection' => $inspection,
                'hospital' => $hospital,
            ]);
        } else
            return $this->render('update', [
                'model' => $model,
                'inspection' => $inspection,
                'hospital' => $hospital,
            ]);
    }



    public function actionSearch($id = null) {
        $request = Yii::$app->request;
        $id = $request->getQueryParam('id');
        $hosp_id = $request->getQueryParam('hosp_id');
        $query = Inspection::find()->joinWith(['inspHospMaps' => function ($query) use($hosp_id) {
            $query->onCondition(['inspHospMaps.hosp_id' => $hosp_id]);
        }]);

        if ($id)
            $query = $query->andWhere(['t.parent_id' => $id]);
        else
            $query = $query->andWhere('t.parent_id is null');
        $models = $query->all();
        $data = [];
        foreach ($models as $model) {
            $attr = [];
            $attr['id'] = 'tree-id-' . $model->level . '-' . $model->id;
            $attr['level'] = $model->level;
            $attr['selected'] = $model->inspHospMaps ? true : false;
            if ($model->isleaf)
                $attr['data-icon'] = 'glyphicon glyphicon-file';
            $fb = isset($model->inspHospMaps->feedback_score) ? $model->inspHospMaps->feedback_score : 0;
            $row = [
                //'name' => $model->name . ($model->isleaf ? " (评分: $fb)" : ''),
                'name' => $model->name,
                'type' => $model->isleaf ? 'item' : 'folder',
                'dataAttributes' => $attr,
            ];
            $data[] = $row;
        }
        return Json::encode($data);
    }

    /**
     * Deletes an existing InspectionHospitalMap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $request = Yii::$app->request;
        $hosp_id = $request->getQueryParam('hosp_id');
        $insp_id = $request->getQueryParam('insp_id');
        $inspection = Inspection::findOne($insp_id);
        $model = InspectionHospitalMap::find()->andWhere(['hosp_id' => $hosp_id, 'insp_id' => $insp_id])->one();
        if (!$model || !$inspection)
            $this->throwNotFound();
        $model->delete(true);
        //$model = InspectionHospitalMap::find()->andWhere([''])
        if ($request->isAjax)
            return '删除成功';
        return $this->redirect(['index']);
    }

    /**
     * Finds the InspectionHospitalMap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return InspectionHospitalMap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InspectionHospitalMap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function throwNotFound() {
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
