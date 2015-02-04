<?php
namespace app\components;

use Yii;
use yii\rbac\Assignment;

class PhpManager extends \yii\rbac\PhpManager {

	public $roleMap = array();

    public function init()
    {
        parent::init();
        if (!Yii::$app->user->isGuest) {
            //$this->assignMe($this->roleMap[Yii::$app->user->identity->role]);
        }
    }

    /**
     * @inheritdoc
     */
    public function assignMe($role, $userId = null)
    {
    	$user = Yii::$app->user->identity;
    	$userId = $user->id;
    	if (!isset($this->assignments[$userId]))
    		$this->assignments[$userId] = [];
        $this->assignments[$userId][$role] = new Assignment([
            'userId' => $userId,
            'roleName' => $role,
            'createdAt' => $user->ctime,
        ]);
        return $this->assignments[$userId][$role];
    }

}
