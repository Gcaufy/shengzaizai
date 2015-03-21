<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_wechat}}".
 *
 * @property string $open_id
 * @property string $user_id
 * @property integer $process
 * @property string $data
 * @property string $ctime
 * @property string $utime
 * @property integer $status
 *
 * @property User $user
 */
class UserWechat extends \common\components\MyActiveRecord
{
    const PROCESS_NEW = 0;
    const PROCESS_LOGIN = 1;
    const PROCESS_REGIST = 2;
    const PROCESS_VALIDATE = 3;
    const PROCESS_BIND = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_wechat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['open_id'], 'required'],
            [['user_id', 'process', 'ctime', 'utime', 'status'], 'integer'],
            [['open_id'], 'string', 'max' => 28],
            [['data'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'open_id' => 'OPEN ID',
            'user_id' => 'USER ID',
            'process' => '当前状态',
            'data' => '数据',
            'ctime' => 'Ctime',
            'utime' => 'Utime',
            'status' => '状态（0为正常，1为已删除）',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function findModel($openId) {
        $model = self::find()->andWhere(['t.open_id' => $openId])->one();
        if (!$model) {
            $model = new UserWechat();
            $model->open_id = $openId;
            $model->save();
        }
        return $model;
    }

}
