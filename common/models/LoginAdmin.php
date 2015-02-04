<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\User as WebUser;

/**
 * Login form
 */
class LoginAdmin extends Model
{
    public $username;
    public $password;
    public $language;
    public $rememberMe = false;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['language','string'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $yiiuser = Yii::$app->user;
            $yiiuser->on(WebUser::EVENT_AFTER_LOGIN, function ($event) {
                //var_dump($event); exit;
                //$auth = Yii::$app->authManager;
            });

            return $yiiuser->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * login log
     * @param  [array] $data
     * @return void
     */
    public function loginlog($data){
        $model = new \backend\modules\system\models\Log();
        $model->id = time().rand(100000,999999);
        $model->adminid = $data['aid'];
        $model->ctime = time();
        $model->url = Yii::$app->request->getPathInfo();
        $model->content = $data['c'];
        $model->save();
    }
}
