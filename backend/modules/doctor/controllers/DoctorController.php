<?php

namespace backend\modules\doctor\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\modules\hospital\models\Hospital;
use backend\modules\doctor\models\Doctor;
use backend\modules\doctor\models\DoctorTag;
use backend\modules\doctor\models\DoctorTagMap;
use backend\modules\doctor\models\DoctorTitle;
use backend\modules\doctor\models\DoctorTitleMap;
use backend\modules\doctor\models\DoctorOperaMap;
use backend\modules\operation\models\Operation;
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
        $hosp_id = $model->hosp_id;
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
        $model->type = 0;
        $hospital = null;
        if ($hosp_id) {
            $model->hosp_id = $hosp_id;
            $hospital = Hospital::find()->andWhere(['t.id' => $hosp_id])->one();
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $sql = '';
                $doctor_id = $model->id;
                if ($model->tag) {
                    $tags = "'" . str_replace(',', "','", $model->tag) . "'";
                    $map = DoctorTagMap::tableName();
                    $tagTable = DoctorTag::tableName();
                    $doctor_id = $model->id;
                    $sql .= "DELETE FROM $map WHERE doctor_id = $doctor_id; INSERT INTO $map (doctor_id, tag_id) SELECT $doctor_id, tag.id FROM $tagTable tag where tag.name in ($tags);";
                }
                if ($model->title) {
                    $titles = "'" . str_replace(' / ', "','", $model->title) . "'";
                    $map = DoctorTitleMap::tableName();
                    $titleTable = DoctorTitle::tableName();
                    $sql .= "DELETE FROM $map WHERE doctor_id = $doctor_id; INSERT INTO $map (doctor_id, title_id) SELECT $doctor_id, title.id FROM $titleTable title where title.name in ($titles);";
                }
                if ($model->operas) {
                    $operas = "'" . str_replace(',', "','", $model->operas) . "'";
                    $map = DoctorOperaMap::tableName();
                    $operaTable = Operation::tableName();
                    $sql .= "DELETE FROM $map WHERE doctor_id = $doctor_id; INSERT INTO $map (doctor_id, opera_id) SELECT $doctor_id, opera.id FROM $operaTable opera where opera.name in ($operas);";
                }
                if ($sql)
                    Yii::$app->db->createCommand($sql)->execute();
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
        $oldTag = $model->tag;
        $oldTitle = $model->title;
        $oldOpera = $model->operas;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {

                $sql = '';
                $doctor_id = $model->id;
                if ($oldTag != $model->tag && $model->tag) {
                    $tags = "'" . str_replace(',', "','", $model->tag) . "'";
                    $map = DoctorTagMap::tableName();
                    $tagTable = DoctorTag::tableName();
                    $doctor_id = $model->id;
                    $sql .= "DELETE FROM $map WHERE doctor_id = $doctor_id; INSERT INTO $map (doctor_id, tag_id) SELECT $doctor_id, tag.id FROM $tagTable tag where tag.name in ($tags);";
                }
                if ($oldTitle != $model->title && $model->title) {
                    $titles = "'" . str_replace(' / ', "','", $model->title) . "'";
                    $map = DoctorTitleMap::tableName();
                    $titleTable = DoctorTitle::tableName();
                    $sql .= "DELETE FROM $map WHERE doctor_id = $doctor_id; INSERT INTO $map (doctor_id, title_id) SELECT $doctor_id, title.id FROM $titleTable title where title.name in ($titles);";
                }
                if ($oldOpera != $model->operas && $model->operas) {
                    $operas = "'" . str_replace(',', "','", $model->operas) . "'";
                    $map = DoctorOperaMap::tableName();
                    $operaTable = Operation::tableName();
                    $sql .= "DELETE FROM $map WHERE doctor_id = $doctor_id; INSERT INTO $map (doctor_id, opera_id) SELECT $doctor_id, opera.id FROM $operaTable opera where opera.name in ($operas);";
                }
                if ($sql)
                    Yii::$app->db->createCommand($sql)->execute();

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
