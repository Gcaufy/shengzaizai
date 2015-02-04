<?php
namespace common\models;

use Yii;
use common\components\MyActiveRecord;
/**
 * This is the model class for table "sys_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $realname
 * @property integer $gender
 * @property string $qq
 * @property string $mobile
 * @property string $tel
 * @property string $email
 * @property string $birth
 * @property string $portrait
 * @property string $authkey
 * @property string $password
 * @property string $note
 * @property integer $role
 * @property integer $status
 * @property integer $uid
 * @property integer $utime
 * @property integer $cid
 * @property integer $ctime
 */
class UserGen extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'role', 'status', 'uid', 'utime', 'cid', 'ctime'], 'integer'],
            [['username', 'tel'], 'string', 'max' => 20],
            [['realname', 'birth'], 'string', 'max' => 10],
            [['qq'], 'string', 'max' => 15],
            [['mobile'], 'string', 'max' => 11],
            [['email'], 'string', 'max' => 45],
            [['portrait', 'note'], 'string', 'max' => 200],
            [['authkey'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 60],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'username' => '用户名',
            'realname' => '真实姓名',
            'gender' => '性别',
            'qq' => 'QQ号码',
            'mobile' => '手机号码',
            'tel' => '联系座机',
            'email' => '电子邮件',
            'birth' => '生日',
            'portrait' => '头像',
            'authkey' => '检验码',
            'password' => '密码',
            'note' => '备注',
            'role' => '角色',
            'status' => '状态',
            'uid' => '更新人',
            'utime' => '更新时间',
            'cid' => '创建人',
            'ctime' => '创建时间',

            'displayGender' => '性别',
        ];
    }
}