<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;

class EncryptController extends Controller
{
	public function __construct(){
		return;
	}

	/**
	 * Encrypt admin password
	 * @param  [string] $var origin word
	 * @param  [string] $authKey 32bit
	 * @return [md5] 32bit
	 */
	public function admin($var,$authKey){
		if(empty($authKey)){
			$authKey = md5('+-+-');
		}
		$str = 'admin|'.$authKey.'|'.$var;
		return md5($str);
	}

	/**
	 * Encrypt teacher user password
	 * @param  [string] $var origin word
	 * @param  string $authKey [auth key]
	 * @return [md5] 32 bit
	 */
	public function teacher($var, $authKey=''){
		if(empty($authKey)){
			$authKey = 'tttt';
		}
		$str = 'teacher+'.$authKey.'+'.$var;
		return md5($str);
	}

	/**
	 * Encrypt parent user password
	 * @param  [string] $var origin word
	 * @param  string $authKey [auth key]
	 * @return [doble md5] 32bit
	 */
	public function parent($var, $authKey=''){
		if(empty($authKey)){
			$authKey = '$$$$';
		}
		$str = 'parent<'.$authKey.'>'.$var;
		return md5(md5($str));
	}
}
