<?php

namespace backend\modules\user\models;

use Yii;
use \common\models\User;

/**
 * This is the model class for table "{{%user_comment}}".
 *
 * @property string $id
 * @property string $hosp_id
 * @property string $doctor_id
 * @property string $insp_id
 * @property string $opera_id
 * @property string $feedback_effect
 * @property string $feedback_manner
 * @property string $comment
 * @property integer $status
 * @property string $uid
 * @property string $utime
 * @property string $cid
 * @property string $ctime
 *
 * @property Doctor $doctor
 * @property Hospital $hosp
 * @property Inspection $insp
 * @property Operation $opera
 */
class UserComment extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hosp_id', 'feedback_effect', 'feedback_manner'], 'required'],
            [['hosp_id', 'doctor_id', 'insp_id', 'opera_id', 'feedback_effect', 'feedback_manner', 'status', 'uid', 'utime', 'cid', 'ctime'], 'integer'],
            [['comment'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hosp_id' => 'Hosp ID',
            'doctor_id' => 'Doctor ID',
            'insp_id' => 'Insp ID',
            'opera_id' => 'Opera ID',
            'feedback_effect' => 'Feedback Effect',
            'feedback_manner' => 'Feedback Manner',
            'comment' => 'Comment',
            'status' => 'Status',
            'uid' => 'Uid',
            'utime' => 'Utime',
            'cid' => 'Cid',
            'ctime' => 'Ctime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHosp()
    {
        return $this->hasOne(Hospital::className(), ['id' => 'hosp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsp()
    {
        return $this->hasOne(Inspection::className(), ['id' => 'insp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpera()
    {
        return $this->hasOne(Operation::className(), ['id' => 'opera_id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'cid'])
            ->from(User::tableName() . ' user');
    }
}
