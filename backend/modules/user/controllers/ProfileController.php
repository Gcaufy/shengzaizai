<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use \common\models\User;

/**
 * MemberController implements the CRUD actions for User model.
 */
class ProfileController extends Controller
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        if ($user->load(Yii::$app->request->post())) {
            if ($user->save()) {
                Yii::$app->session->setFlash('success', '更新成功.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', '更新失败.');
            }
        }
        return $this->render('index', ['user' => $user]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
