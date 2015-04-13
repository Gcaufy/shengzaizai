<?php

namespace backend\modules\user\models;

use Yii;

use backend\modules\cms\models\Article;
use backend\modules\hospital\models\Hospital;
use backend\modules\doctor\models\Doctor;
use backend\modules\inspection\models\Inspection;
use backend\modules\operation\models\Operation;

/**
 * This is the model class for table "szz_user_favor".
 *
 * @property string $id
 * @property string $user_id
 * @property string $hosp_id
 * @property string $doctor_id
 * @property string $insp_id
 * @property string $opera_id
 * @property string $article_id
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 *
 * @property CmsArticle $article
 * @property Doctor $doctor
 * @property Hospital $hosp
 * @property Inspection $insp
 * @property Operation $opera
 * @property User $user
 */
class UserFavor extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'szz_user_favor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'hosp_id', 'doctor_id', 'insp_id', 'opera_id', 'article_id', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer']
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
            'hosp_id' => 'Hosp ID',
            'doctor_id' => 'Doctor ID',
            'insp_id' => 'Insp ID',
            'opera_id' => 'Opera ID',
            'article_id' => 'Article ID',
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
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id'])
            ->from(Article::tableName() . ' article');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id'])
            ->from(Doctor::tableName() . ' doctor');;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHosp()
    {
        return $this->hasOne(Hospital::className(), ['id' => 'hosp_id'])
            ->from(Hospital::tableName() . ' hosp');;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsp()
    {
        return $this->hasOne(Inspection::className(), ['id' => 'insp_id'])
            ->from(Inspection::tableName() . ' insp');;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpera()
    {
        return $this->hasOne(Operation::className(), ['id' => 'opera_id'])
            ->from(Operation::tableName() . ' opera');;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
