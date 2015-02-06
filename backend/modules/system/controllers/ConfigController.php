<?php

namespace backend\modules\system\controllers;

use Yii;
use \common\models\Config;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use backend\controllers\ShiroController;

/**
 * ConfigController implements the CRUD actions for Config model.
 */
class ConfigController extends ShiroController
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
     * Lists all Config models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Config::find()->one();
        if (!$model)
            $model = new Config();
        $post = Yii::$app->request->post();
        if($model->load($post)){
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '更新成功.');
            } else
                Yii::$app->session->setFlash('error', '更新失败.');
            return $this->redirect(['index']);
        }else{
            return $this->render('index', ['model' => $model]);
        }
    }

    /**
     * Creates a new Config model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Config();
        $post = Yii::$app->request->post();
        $postflag = $model->load($post);

        if($postflag){
            if(strlen($model->varname)>20){
                $model->addError('newpassword',Yii::t('app','Parameter name can not be more than 20 characters'));
            }
        }

        if($postflag && !$model->hasErrors() && $model->save()){
            $this->log(['c'=>'添加配置变量:'.$model->varname,'b'=>$model->tableName()]);
            $this->cache(['k'=>'configs','t'=>'w']);
        }

        return $this->render('index', [
            'dataProvider' => $this->cache(['k'=>'configs']),
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Config model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Config model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Config the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Config::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
