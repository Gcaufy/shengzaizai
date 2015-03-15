<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use \common\models\User;
use \common\models\finance\Balance;
use \common\models\finance\GeneralLedger;
use \common\components\Finance;

/**
 * MemberController implements the CRUD actions for User model.
 */
class AccountController extends Controller
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GeneralLedger();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $balance = Finance::getBalance();

        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'balance' => $balance]);
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
