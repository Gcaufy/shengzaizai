<?php
namespace api\controllers;

use Yii;
use api\components\MsgHelper;

/**
 * FeedbackController
 */
class FeedbackController extends BaseController
{
    public $modelClass = 'api\models\Feedback';
    protected $loginRequired = true;

    public function actions() {
        return [];
    }

    public function actionCreate() {
        $modelClass = $this->modelClass;
        $model = new $modelClass;
        if ($model->load(Yii::$app->request->getBodyParams(), '')) {
            $model->user_id = Yii::$app->user->identity->id;
            if ($model->save()) {
                return MsgHelper::success('保存成功');
            }
            return MsgHelper::faile('保存失败.', $model->getErrors());
        }
        return MsgHelper::faile('参数出错');
    }
}
