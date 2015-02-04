<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class UploadController extends Controller
{

	public function actionImage(){
		$imgpath = '/'.date('Ymd').'/';
		$uploaddir = realpath('../../images/').$imgpath;
		if(!file_exists($uploaddir)){
			mkdir($uploaddir);
		}
		$ret = [];
		if (!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name']) || $_FILES['file']['error'] != 0) {
			echo json_encode(['error'=>'错误:无效上传']);
			exit(0);
		}
		$ext = explode('.', $_FILES['file']['name']);
		$fname = md5(microtime()).'.'.end($ext);
		move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir.$fname);
		if(file_exists($uploaddir.$fname)){
			$ret['ok'] = '1';
			$ret['fpath'] = $imgpath.$fname;
			$ret['fname'] = $fname;
			$ret['domain']= Yii::$app->params['imageroot'];
		}else{
			$ret['error'] = '文件上传失败，请稍候再试';
		}
		echo json_encode($ret);
		die();
	}

	public function actionDelete(){
		$ret = [];
		$imgpath = $_POST['key'];
		$uploaddir = realpath('../../images/').$imgpath;
		if(file_exists($uploaddir)){
			unlink($uploaddir);
		}
		echo json_encode($ret);
		exit;
	}

	public function actionIndex(){
		$this->layout = 'upload';
		return $this->render('index');
	}
}

?>