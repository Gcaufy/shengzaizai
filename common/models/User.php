<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\user\models\Parents;
use backend\modules\user\models\Student;
use backend\modules\user\models\Teacher;

/**
 * User model
 *
 * @property integer $id
 * @property string $mobile
 * @property string $password
 * @property string $password_reset_token
 * @property string $email
 * @property string $authkey
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends \common\models\UserGen implements \yii\web\IdentityInterface
{
    const ROLE_ADMIN    = 1; // 管理员
    const ROLE_NORMAL  = 2; // 注册用户

    const TYPE_FOR_PREGNANT = 1;
    const TYPE_PREGNANT = 2;
    const TYPE_EXPECTANT = 3;
    const TYPE_POSTPARTUM = 4;
    const TYPE_OTHER = 5;


    const FROM_IOS = 1;
    const FROM_ANDROID = 2;
    const FROM_WECHAT = 3;
    const FROM_OTHER = 0;

    public $rememberMe = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['mobile', 'required'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        $unsafe_fields = ['authkey', 'password'];
        return array_diff($fields, $unsafe_fields);
    }

    public static function getRoleMap() {
        return [
            self::ROLE_ADMIN => '管理员',
            self::ROLE_NORMAL => '注册用户',
        ];
    }

    public static function getTypeMap() {
        return [
            self::TYPE_FOR_PREGNANT => '备孕中',
            self::TYPE_PREGNANT => '怀孕中',
            self::TYPE_EXPECTANT => '待产',
            self::TYPE_POSTPARTUM => '产后',
            self::TYPE_OTHER => '其它',
        ];
    }

    public function getRole($role = null) {
        $arr = User::getRoleMap();
        $role = $role ? $role : $this->role;
        return $role ? $arr[$role] : $arr;
    }

    public function isAdmin() {
        return $this->getRole() == self::ROLE_ADMIN;
    }
    public function isMember() {
        return $this->getRole() == self::ROLE_NORMAL;
    }
    public function isTeacher() {
        return $this->getRole() == self::ROLE_TEACHER;
    }
    public function isParent() {
        return $this->getRole() == self::ROLE_PARENT;
    }
    public function isStudent() {
        return $this->getRole() == self::ROLE_STUDENT;
    }

    public function getDisplayName() {
        return $this->realname ? $this->realname : $this->mobile;
    }

    public function getDisplayGender() {
        return ($this->gender == 0 || $this->gender == 1) ? Yii::$app->params['gender'][$this->gender] : '';
    }


    public static function checkAction($url) {
        if (substr($url, 0, 2) === '//') {
            $route = substr($url, strpos($url, '/', 2) + 1);
        } else {
            $route = substr($url, 1);
        }
        $action = 'action.' . str_replace('/', '.', $route);
        $i = strpos($action, '?');
        if ($i !== false)
            $action = substr($action, 0, $i);
        return Yii::$app->user->can($action);
    }
    public function login() {
        if ($this->validate()) {
            $yiiuser = Yii::$app->user;

            return $yiiuser->login($this, $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }


    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find(UserQuery::className());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $token = UserToken::findOne(['token' => $token]);
        return is_null($token) ? null : static::findOne($token->user_id);
    }

    /**
     * Finds user by mobile
     *
     * @param string $mobile
     * @return static|null
     */
    public static function findByMobile($mobile)
    {
        $user = static::findOne(['mobile' => $mobile]);
        return $user;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    public function setAuthKey($v)
    {
        return $this->auth_key = $v;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $str = 'admin|' . $this->authKey . '|' . $password;
        return Yii::$app->security->validatePassword(md5($str), $this->password);
    }

    public function setSimplePassword()
    {
        // 123456
        $this->authkey = 'Wxo4U2ii9OcIWCLwQuVgSEbEXz3ZsA1B';
        $this->password = '$2y$13$Dv9iu/pbxHIvpAPemN8nn.6Ch72xDKQ7167hUeq/fn0I5u9qZZSPS';
        return $this;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password = null)
    {
        if (!$password) {
            $password = $this->password;
        }
        $this->authkey = Yii::$app->security->generateRandomString();
        $str = 'admin|' . $this->authKey . '|' . $password;
        $this->password = Yii::$app->security->generatePasswordHash(md5($str));
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authkey = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}

class UserQuery extends \common\components\ActiveQuery
{

    public function message()
    {
        if (Yii::$app->user->isGuest) {
            $this->andWhere('1 = 0');
        }
        $user = Yii::$app->user->identity;
        $alias = $this->tableAlias;
        switch ($user->role) {
            case User::ROLE_PARENT:
                if (isset($user->parent->classes)) {
                    $this->joinWith(['teacher' => function ($q) {
                        $q->joinWith(['classes'], true, 'INNER JOIN');
                    }], true, 'INNER JOIN');
                    $condition = ['in', 'class.id', ArrayHelper::getColumn($user->parent->classes, 'id')];
                }
                break;
            case User::ROLE_TEACHER:
                if (isset($user->teacher->classes)) {
                    $this->modelClass = Parents::className();
                    $this->joinWith(['classes'], true, 'INNER JOIN');
                    $condition = ['in', 'class.id', ArrayHelper::getColumn($user->teacher->classes, 'id')];
                }
                break;
        }
        $this->distinct();
        if (isset($condition)) {
            $this->andWhere($condition);
        } else {
            $this->andWhere('1 = 0');
        }
        return $this;
    }

}
