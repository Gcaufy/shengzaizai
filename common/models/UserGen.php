<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $realname
 * @property string $mobile
 * @property string $email
 * @property string $auth_key
 * @property string $password
 * @property string $payment_password
 * @property integer $pregnant
 * @property integer $role
 * @property integer $status
 * @property integer $utime
 * @property integer $uid
 * @property integer $ctime
 * @property integer $cid
 *
 * @property SystemFeedback[] $systemFeedbacks
 * @property UserBalance[] $userBalances
 * @property UserFavor[] $userFavors
 * @property UserPayment[] $userPayments
 */
class UserGen extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pregnant', 'role', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['realname', 'email'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['password', 'payment_password'], 'string', 'max' => 60],
            [['mobile'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'realname' => '真实姓名',
            'mobile' => '手机号',
            'email' => '邮箱',
            'auth_key' => '密钥',
            'password' => '登陆密码',
            'payment_password' => '支付密码',
            'pregnant' => '怀孕状态',
            'role' => '1: 管理员',
            'status' => 'Status',
            'utime' => 'Utime',
            'uid' => 'Uid',
            'ctime' => 'Ctime',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemFeedbacks()
    {
        return $this->hasMany(SystemFeedback::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserBalances()
    {
        return $this->hasMany(UserBalance::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavors()
    {
        return $this->hasMany(UserFavor::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPayments()
    {
        return $this->hasMany(UserPayment::className(), ['user_id' => 'id']);
    }
}
