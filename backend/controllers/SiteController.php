<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;

use backend\modules\message\models\Note;
use backend\modules\message\models\NoteRead;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'login';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error', 'login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'denied'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'main';
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $user = User::findByMobile($model->mobile);
            $logintimes = intval(Yii::$app->session->get('logintimes'));
            if(isset($user)){
                if(false && ($user->status == 9 || $logintimes>2)){
                    $user->addError('password',Yii::t('app','Login failed 3 times, locked'));
                    return $this->render('login', ['model' => $user]);
                }else{
                    $encrypt = new \common\controllers\EncryptController();
                    $user->password = $encrypt->admin($user->password,$user->authkey);
                    if($user->login()){
                        Yii::$app->session->set('logintimes',0);
                        return $this->goHome();
                    }else{
                        $logintimes++;
                        Yii::$app->session->set('logintimes',$logintimes);
                        return $this->render('login', ['model' => $user]);
                    }
                }
            }else{
                $model->addError('mobile','手机号不存在');
                return $this->render('login', ['model' => $model]);
            }
        } else {
            $user->rememberMe = 0;
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionDenied()
    {
        $this->layout = 'main';
        return $this->render('denied');
    }

    public function actionCome()
    {
        $this->layout = 'main';
        return $this->render('come');
    }

    public function actionError() {
        echo 'site/error';
        exit;
    }
}
