<?php

namespace backend\modules\order\controllers;

use Yii;
use backend\modules\order\models\Order;
use backend\modules\order\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{

    public $_grid_button = null;

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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $process = isset($_POST['process']) ? $_POST['process'] : null;
        if ($id && $process && ($model = Order::findOne($id))) {
            $model->process = $process;
            $model->save();
        }

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
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
     * Updates an existing Order model.
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
        ]);
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    public function getProcessGridButton($id) {
        if (!$this->_grid_button) {
            $map = Order::getProcessMap();
            $li = '';
            $color = [Order::PROCESS_DONE => 'success', Order::PROCESS_DUE => 'warning', Order::PROCESS_CANCEL => 'important', ];
            foreach ($map as $k => $value) {
                if ($k === Order::PROCESS_NEW)
                    continue;
                $li .= "<li><a data=\"{$k}\" href=\"javascript:;\"><span class=\"badge badge-{$color[$k]}\">&nbsp;</span> &nbsp;$value</a></li>";
            }
            $this->_grid_button = "<button class=\"btn btn-default btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">
                    标记 <span class=\"caret\"></span>
                </button>
                <ul class=\"btn_mark dropdown-menu\" role=\"menu\">
                    $li
                </ul>";
        }
        return "<div class=\"btn-group\" data=\"$id\">" . $this->_grid_button . "</div>";
    }
}
