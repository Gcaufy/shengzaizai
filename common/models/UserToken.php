<?php

namespace common\models;

use Yii;
use common\components\IpHelper;

/**
 * This is the model class for table "{{%user_token}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $token
 * @property integer $ip
 * @property string $agent
 * @property integer $ctime
 */
class UserToken extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
               [['user_id', 'ip', 'ctime'], 'integer'],
               [['agent'], 'string', 'max' => 200],
               [['token'], 'string', 'max' => 50]
        ];
    }

    protected function setAccessInfo()
    {
        $this->ip = IpHelper::ip2int(Yii::$app->request->userIP);
        $this->agent = Yii::$app->request->userAgent;
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
        $token->token = Yii::$app->security->generateRandomString();
        $token->setAccessInfo();
        $token->ctime = time();
        $token->save();
        return $token->token;
    }

    public static function updateAccessInfo($user_id)
    {
        $token = static::findByUserId($user_id);
        $token->setAccessInfo();
        return $token->save();
    }
}
