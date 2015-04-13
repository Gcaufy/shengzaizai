<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\user\models\UserFavor;
use yii\data\ActiveDataProvider;

/**
 * MemberController implements the CRUD actions for User model.
 */
class FavorController extends Controller
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dp_article = new ActiveDataProvider([
            'query' => UserFavor::find()->me()->joinWith('article')->andWhere('t.article_id is not null'),
        ]);
        $dp_doctor = new ActiveDataProvider([
            'query' => UserFavor::find()->me()->andWhere('t.doctor_id is not null'),
        ]);
        $dp_opera = new ActiveDataProvider([
            'query' => UserFavor::find()->me()->andWhere('t.opera_id is not null'),
        ]);
        $dp_insp = new ActiveDataProvider([
            'query' => UserFavor::find()->me()->andWhere('t.insp_id is not null'),
        ]);
        $dp_hosp = new ActiveDataProvider([
            'query' => UserFavor::find()->me()->andWhere('t.hosp_id is not null and t.opera_id is null and t.insp_id is null'),
        ]);
        return $this->render('index', [
            'dp_article' => $dp_article,
            'dp_doctor' => $dp_doctor,
            'dp_opera' => $dp_opera,
            'dp_insp' => $dp_insp,
            'dp_hosp' => $dp_hosp,
        ]);
    }
}
