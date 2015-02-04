<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $access_token
 * @property integer $ctime
 * @property integer $utime
 * @property boolean $status
 */
class UserToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_token';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['ctime', 'utime'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['utime'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'ctime', 'utime'], 'integer'],
            [['access_token'], 'string', 'max' => 32],
            [['last_login_ip'], 'string', 'max' => 39],
            [['user_agent'], 'string', 'max' => 255],
            [['status'], 'boolean'],
        ];
    }

    protected function setAccessInfo()
    {
        $this->last_login_ip = Yii::$app->request->userIP;
        $this->user_agent = Yii::$app->request->userAgent;
    }

    protected static function findByUserId($user_id)
    {
        $token = static::findOne(['user_id' => $user_id]);
        if (is_null($token)) {
            $token = new static();
            $token->user_id = $user_id;
        }
        return $token;
    }

    public static function updateToken($user_id)
    {
        $token = static::findByUserId($user_id);
        $token->access_token = Yii::$app->security->generateRandomString();
        $token->setAccessInfo();
        $token->save();
        return $token->access_token;
    }

    public static function updateAccessInfo($user_id)
    {
        $token = static::findByUserId($user_id);
        $token->setAccessInfo();
        return $token->save();
    }

}
