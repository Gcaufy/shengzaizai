<?php

namespace backend\modules\system\models;

use Yii;

/**
 * This is the model class for table "sys_sms_log".
 *
 * @property integer $id
 * @property string $mobiles
 * @property string $content
 * @property integer $ctime
 * @property integer $utime
 * @property integer $status
 */
class SmsLog extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%sms_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobiles', 'content'], 'required'],
            [['mobiles', 'content'], 'string'],
        ];
    }
}
