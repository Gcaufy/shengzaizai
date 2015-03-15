<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\modules\doctor\models\Doctor;
use backend\modules\hospital\models\Hospital;
use backend\modules\operation\models\Operation;
use backend\modules\inspection\models\Inspection;

class ShiroController extends Controller
{
	public function behaviors(){
		return [

		];
	}

	public function beforeAction($action){
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        return true;
        //Yii::$app->language = Yii::$app->session->get('language');
        $curpath = '/'.$this->module->id.'/'.Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
        $rules_admin = Yii::$app->user->identity->attributes['rules'];
        $rules_group = $this->cache(['k'=>'rules','id'=>Yii::$app->user->identity->attributes['groupid']]);
        if(!empty($rules_admin)){
            $rules_admin = unserialize($rules_admin);
        }
        if(!empty($rules_group)){
            $rules_group = unserialize($rules_group);
        }
        if(empty($rules_admin)){
            $rules_admin = [];
        }
        if(empty($rules_group)){
            $rules_group = [];
        }
        $rules = array_merge($rules_admin, $rules_group);
        if(!in_array($curpath, $rules)){
            //return $this->redirect(['/site/denied']);
        }
        return true;
	}

	public function actionIndex(){

    }

    public function log($d){
        $model = new \backend\modules\system\models\Log();
        $model->id = isset($d['id']) ? $d['id'] : time().rand(100000,999999);
        $model->ctime = time();
        $model->adminid = isset($d['aid']) ? $d['aid'] : Yii::$app->user->identity->attributes['id'];
        $model->url = isset($d['u']) ? $d['u'] : Yii::$app->request->getPathInfo();
        $model->content = $d['c'];
        $model->save();
    }

    /**
     * write config data to cache
     * @param  [array] $data
     * @return void
     */
    public function cacheConfig($data){
        $switch = [];
        if(isset(Yii::$app->params['switch'])){
            $switch = Yii::$app->params['switch'];
        }
        if(!$switch['memcache']){
            return;
        }
        Yii::$app->cache->serializer = false;
        foreach ($data as $k => $v) {
            Yii::$app->cache->set(trim($v['varname']),$v['value']);
        }
    }

    public function cache($data, $expire = 10){
    	$switch = [];
    	if(isset(Yii::$app->params['switch'])){
    		$switch = Yii::$app->params['switch'];
    	}

    	switch ($data['k']) {
            case 'adminlist':
                $ret = [];
                $model = new \backend\modules\system\models\Admin();
                $ret = $model->fetchAll();
                return $ret;
                break;
    		case 'admingroup':
    			if(isset($data['t']) && $data['t']=='w'){
                    if($switch['memcache']){
                        $model = new \backend\modules\system\models\Group();
                        Yii::$app->cache->set($data['k'],$model->fetchAll());
                    }
    			}else{
    				$ret = [];
    				if($switch['memcache']){
    					$ret = Yii::$app->cache->get($data['k']);
    				}
    				if(empty($ret)){
    					$model = new \backend\modules\system\models\Group();
    					$ret = $model->fetchAll();
    					if($switch['memcache']){
    						Yii::$app->cache->set($data['k'],$ret);
    					}
    				}
    				return $ret;
    			}
    			break;
            case 'rules':
                $rel = $this->cache(['k'=>'admingroup']);
                foreach ($rel as $k => $v) {
                    if($v['id']==$data['id']){
                        return $v['rules'];
                    }
                }
                break;
            case 'configs':
                if(isset($data['t']) && $data['t']=='w'){
                    if($switch['memcache']){
                        $model = new \backend\modules\system\models\Config();
                        $config = $model->getConfigs();
                        Yii::$app->cache->set($data['k'],$config);
                        $this->cacheConfig($config);
                    }
                }else{
                    $configs = [];
                    if($switch['memcache']){
                        $configs = Yii::$app->cache->get($data['k']);
                    }
                    if(empty($configs)){
                        $model = new \backend\modules\system\models\Config();
                        $configs = $model->getConfigs();
                        if($switch['memcache']){
                            Yii::$app->cache->set($data['k'],$configs);
                        }
                    }
                    return $configs;
                }
                break;
            case 'cmsclasses':
                if(isset($data['t']) && $data['t']=='w'){
                    if($switch['memcache']){
                        $model = new \backend\modules\cms\models\Classes();
                        Yii::$app->cache->set($data['k'],$model->fetchAll());
                    }
                }else{
                    $ret = [];
                    if($switch['memcache']){
                        $ret = Yii::$app->cache->get($data['k']);
                    }
                    if(empty($ret)){
                        $model = new \backend\modules\cms\models\Classes();
                        $ret = $model->fetchAll();
                        if($switch['memcache']){
                            Yii::$app->cache->set($data['k'],$ret);
                        }
                    }
                    return $ret;
                }
                break;
            case 'subjectlist':
                if(isset($data['t']) && $data['t']=='w'){
                    if($switch['memcache']){
                        $model = new \backend\modules\school\models\Subject();
                        Yii::$app->cache->set($data['k'],$model->fetchAll());
                    }
                }else{
                    $ret = [];
                    if($switch['memcache']){
                        $ret = Yii::$app->cache->get($data['k']);
                    }
                    if(empty($ret)){
                        $model = new \backend\modules\school\models\Subject();
                        $ret = $model->fetchAll();
                        if($switch['memcache']){
                            Yii::$app->cache->set($data['k'],$ret);
                        }
                    }
                    return $ret;
                }
                break;
    		default:
    			return ;
    			break;
    	}
    }




    public function actionHospsearch($search = null, $id = null)
    {
        $output = ['results' => [], 'more' => false];
        if ($search !== null) {
            $hosps = Hospital::find()
                ->andFilterWhere(['like', 't.name', $search])
                ->limit(20)
                ->all();
        } elseif (strlen($id) > 0) {
            $hosp = Hospital::find()->andWhere(['in', 't.id', explode(',', $id)])->one();
            $output['results'] = [
                'id' => $hosp->id,
                'text' => $hosp->name,
            ];

        }
        if (!empty($hosps)) {
            $output['results'] = ArrayHelper::getColumn($hosps, function($hosp) {
                return [
                    'id' => $hosp->id,
                    'text' => $hosp->name,
                ];
            });
        }
        return Json::encode($output);
    }
    public function actionDoctorsearch($search = null, $id = null)
    {
        $output = ['results' => [], 'more' => false];
        if ($search !== null) {
            $doctors = Doctor::find()
                ->andFilterWhere(['like', 't.name', $search])
                ->limit(20)
                ->all();
        } elseif (strlen($id) > 0) {
            $doctor = Doctor::find()->andWhere(['in', 't.id', explode(',', $id)])->one();
            $output['results'] = [
                'id' => $doctor->id,
                'text' => $doctor->name,
            ];

        }
        if (!empty($doctors)) {
            $output['results'] = ArrayHelper::getColumn($doctors, function($doctor) {
                return [
                    'id' => $doctor->id,
                    'text' => $doctor->name,
                ];
            });
        }
        return Json::encode($output);
    }
    public function actionOperasearch($search = null, $id = null)
    {
        $output = ['results' => [], 'more' => false];
        if ($search !== null) {
            $operas = Operation::find()
                ->andFilterWhere(['like', 't.name', $search])
                ->limit(20)
                ->all();
        } elseif (strlen($id) > 0) {
            $opera = Operation::find()->andWhere(['in', 't.id', explode(',', $id)])->one();
            $output['results'] = [
                'id' => $opera->id,
                'text' => $opera->name,
            ];

        }
        if (!empty($operas)) {
            $output['results'] = ArrayHelper::getColumn($operas, function($opera) {
                return [
                    'id' => $opera->id,
                    'text' => $opera->name,
                ];
            });
        }
        return Json::encode($output);
    }
    public function actionInspsearch($search = null, $id = null)
    {
        $output = ['results' => [], 'more' => false];
        if ($search !== null) {
            $insps = Inspection::find()
                ->andFilterWhere(['like', 't.name', $search])
                ->limit(20)
                ->all();
        } elseif (strlen($id) > 0) {
            $insp = Inspection::find()->andWhere(['in', 't.id', explode(',', $id)])->one();
            $output['results'] = [
                'id' => $insp->id,
                'text' => $insp->name,
            ];

        }
        if (!empty($insps)) {
            $output['results'] = ArrayHelper::getColumn($insps, function($insp) {
                return [
                    'id' => $insp->id,
                    'text' => $insp->name,
                ];
            });
        }
        return Json::encode($output);
    }
}
?>