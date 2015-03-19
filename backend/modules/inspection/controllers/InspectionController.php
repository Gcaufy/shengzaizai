<?php

namespace backend\modules\inspection\controllers;

use Yii;
use backend\modules\inspection\models\Inspection;
use backend\modules\inspection\models\InspectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\controllers\ShiroController;

/**
 * InspectionController implements the CRUD actions for Inspection model.
 */
class InspectionController extends ShiroController
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
     * Lists all Inspection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InspectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inspection model.
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
     * Creates a new Inspection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $parent_id = Yii::$app->request->getQueryParam('parent_id');
        $parent = Inspection::find()->andWhere(['t.id' => $parent_id])->one();
        $model = new Inspection();
        $model->parent_id = $parent ? $parent_id : 0;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->parent_id == 0) {
                $model->parent_id = null;
                $model->level = 0;
            } else {
                $model->level = 1;
                $parent = $this->findModel($model->parent_id);
                $parent->isleaf = 0;
                $parent->save();
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '创建成功.');
                if (Yii::$app->request->isAjax) {
                    return $this->actionView($model->id);
                } else
                    return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', '创建失败.');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'parent' => $parent,
        ]);
    }

    /**
     * Updates an existing Inspection model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parent = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '更新成功.');
                if (Yii::$app->request->isAjax) {
                    return $this->actionView($model->id);
                } else
                    return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', '更新失败.');
            }
        }
        if ($model->parent_id == null) {
            $model->parent_id = 0;
        } else {
            $parent = Inspection::find()->andWhere(['t.id' => $model->parent_id])->one();
        }
        return $this->render('update', [
            'model' => $model,
            'parent' => $parent,
        ]);
    }

    /**
     * Deletes an existing Inspection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $a = $this->findModel($id)->delete();
        if (Yii::$app->request->isAjax) {
            return '删除成功';
        } else
            return $this->redirect(['index']);
    }

    public function actionSearch($id = null) {

        $query = Inspection::find();
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
            if ($model->isleaf)
                $attr['data-icon'] = 'glyphicon glyphicon-file';
            $row = [
                'name' => $model->name,
                'type' => $model->isleaf ? 'item' : 'folder',
                'dataAttributes' => $attr,
            ];
            $data[] = $row;
        }
        return Json::encode($data);
    }

    public function actionParentsearch($search = null, $id = null)
    {
        $output = ['results' => [['id' => '0', 'text' => '父级项目']]];
        if ($id === '0') {
            return Json::encode(['results' => ['id' => '0', 'text' => '父级项目'], 'more' => false]);
        }
        if ($search !== null) {
            $ps = Inspection::find()
                ->andFilterWhere(['like', 't.name', $search])
                ->limit(20)
                ->all();
        } elseif (strlen($id) > 0) {
            $p = Inspection::find()->andWhere(['in', 't.id', explode(',', $id)])->andWhere('t.parent_id is null')->one();
            $output['results'] = [
                'id' => $p->id,
                'text' => $p->name,
            ];

        }
        if (!empty($ps)) {
            foreach ($ps as $key => $p) {
                $output['results'][] = [
                    'id' => $p->id,
                    'text' => $p->name,
                ];
            }
        }
        return Json::encode($output);
    }

    /**
     * Finds the Inspection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Inspection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inspection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
