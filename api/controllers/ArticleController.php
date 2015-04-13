<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use api\models\Category;
use api\models\Article;
use backend\modules\cms\models\ArticlePositive;
use common\components\IpHelper;
use api\components\MsgHelper;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class ArticleController extends BaseController
{
    public $modelClass = 'api\models\Article';
    protected $loginRequired = false;

    public function actionCategory() {
        return Category::find()->all();
    }

    public function actionAll() {
        return Category::find()->joinWith('articles')->asArray()->all();
    }

    public function actionPositive() {

        $accessToken = Yii::$app->request->get('token');
        if (is_string($accessToken)) {
            $identity = Yii::$app->user->loginByAccessToken($accessToken);
            if ($identity !== null) {
                Yii::$app->user->identity = $identity;
            }
        }
        $isGuest = Yii::$app->user->isGuest;


        $modelClass = $this->modelClass;
        $model = new $modelClass();

        $ap = new ArticlePositive();
        $ap->load(Yii::$app->getRequest()->getBodyParams(), '');
        $ap->ip = IpHelper::ip2int(Yii::$app->request->userIP);
        if (!($article = $model::findOne($ap->article_id))) {
            throw new NotFoundHttpException('无效参数.');
        }
        $param = ['t.article_id' => $ap->article_id];

        if ($isGuest)
            $param['t.ip'] = $ap->ip;
        else
            $param['t.cid'] = Yii::$app->user->identity->id;

        if (ArticlePositive::find()->andWhere($param)->one()) {
            return MsgHelper::faile('您已点赞');
        }
        $tran = Yii::$app->db->beginTransaction();
        $article->positive++;
        if ($article->save() && $ap->save()) {
            $tran->commit();
        } else {
            $tran->rollback();
        }
    }
}
