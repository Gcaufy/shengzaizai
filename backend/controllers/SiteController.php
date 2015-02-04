<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginAdmin;
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
        $unReadNote = Note::find()->joinWith('unReadNote')->count('DISTINCT `t`.`id`');

        $this->layout = 'main';
        return $this->render('index', array(
            'unReadNote' => $unReadNote,
        ));
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginAdmin();

        if ($model->load(Yii::$app->request->post())) {
            $model->getUser();
            $logintimes = intval(Yii::$app->session->get('logintimes'));
            if(isset($model->user)){
                if(false && ($model->user->status == 9 || $logintimes>2)){
                    $model->addError('password',Yii::t('app','Login failed 3 times, locked'));
                    return $this->render('login', ['model' => $model]);
                }else{
                    $encrypt = new \common\controllers\EncryptController();
                    $model->password = $encrypt->admin($model->password,$model->user->authkey);
                    if($model->login()){
                        Yii::$app->session->set('logintimes',0);
                        $model->loginlog(['m'=>'login','aid'=>$model->user->id, 'c'=>'登录成功']);
                        return $this->goHome();
                    }else{
                        $logintimes++;
                        Yii::$app->session->set('logintimes',$logintimes);
                        $model->loginlog(['m'=>'login','aid'=>$model->user->id, 'c'=>'登录失败'.$logintimes.'次']);
                        return $this->render('login', ['model' => $model]);
                    }
                }
            }else{
                $model->addError('username','用户名不存在');
                return $this->render('login', ['model' => $model]);
            }
        } else {
            $model->rememberMe = 0;
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

    public function actionError()
    {
        echo 'site/error';
        exit;
    }
}
