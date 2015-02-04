<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

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
}
?>