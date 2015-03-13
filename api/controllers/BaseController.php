<?php
namespace api\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use common\models\UserToken;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class BaseController extends \yii\rest\ActiveController
{

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @var boolean whether login is required for current controller
     */
    protected $loginRequired = true;

    /**
     * @var array actions which are not be allowed to be performed by current user
     */
    protected $deniedActions = [];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'index' => [
                'prepareDataProvider' => [$this, 'prepareDataProvider'],
            ],
            'view' => [
                'findModel' => [$this, 'findModel'],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if ($this->loginRequired) {
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
            ];
        } else {
            unset($behaviors['authenticator']);
        }
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if ($this->loginRequired) {
            $token = UserToken::findOne(['user_id' => Yii::$app->user->identity->id]);
            // 24 * 60 * 60 = 86400
            if (time() - $token->utime > 86400) {
                throw new ForbiddenHttpException('Token expired');
            }
        }
        if (in_array($action, $this->deniedActions)) {
            throw new ForbiddenHttpException("You are not allowed to perform {$action} action");
        }
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($this->loginRequired) {
            UserToken::updateAccessInfo(Yii::$app->user->identity->id);
        }
        return parent::afterAction($action, $result);
    }

    /**
     * implement this method to change the default dataProvider for IndexAction
     * @return yii\data\ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass();
        $query = $model::find();

        $filter = Yii::$app->request->get('filter');
        if (is_string($filter)) {
            try {
                $filters = Json::decode($filter);
                foreach ($filters as $key => $value) {
                    if ($model->hasAttribute($key)) {
                        $field = "t.{$key}";
                        if (is_array($value)) {
                            $query->andFilterWhere(['in', $field, $value]);
                        } elseif (ctype_digit($value)) {
                            $query->andFilterWhere([$field => $value]);
                        } elseif (is_string($value)) {
                            $query->andFilterWhere(['like', $field, $value]);
                        }
                    }
                }
            } catch (InvalidParamException $e) {
                // json object is invalid, do not apply any filter
            }
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * implement this method to extend the fields for ViewAction
     * @return array
     */
    public function findModel($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne($id);
        if (is_null($model)) {
            throw new NotFoundHttpException("Object not found: $id");
        }
        return $model;
    }

}
