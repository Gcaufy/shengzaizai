<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "{{%fin_balance}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $amount
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 *
 * @property User $user
 */
class Balance extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fin_balance}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['amount'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
