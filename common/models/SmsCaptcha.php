<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sms_captcha}}".
 *
 * @property integer $id
 * @property string $mobile
 * @property string $captcha
 * @property integer $type
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 */
class SmsCaptcha extends \common\components\MyActiveRecord
{

    const TYPE_REGISTER = 1;
    const TYPE_RESET_PASSWORD = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sms_captcha}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'type'], 'required'],
            [['type', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['mobile'], 'string', 'max' => 20],
            [['captcha'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => '收信人',
            'captcha' => '验证码',
            'type' => '验证码类型',
            'status' => '状态',
            'utime' => '修改时间',
            'uid' => '修改人',
            'ctime' => '创建时间',
            'cid' => '创建人',
        ];
    }

    public function init() {
        parent::init();
        $this->captcha = mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
    }

    public function checkExsit() {
        $time = time();
        return self::find()
            ->andWhere(['mobile' => $this->mobile, 'type' => $this->type])
            ->andWhere("$time - ctime < 60")->one();
    }


    public static function getCaptcha($captcha, $mobile, $type) {
        return self::find()
            ->andWhere(['captcha' => $captcha, 'type' => $type, 'mobile' => $mobile ])
            ->one();
    }
}
