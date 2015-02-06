<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%system_config}}".
 *
 * @property string $id
 * @property string $app_name
 * @property string $version
 * @property string $feature
 * @property string $about
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 */
class Config extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['app_name'], 'string', 'max' => 50],
            [['version'], 'string', 'max' => 10],
            [['feature', 'about'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_name' => '系统名称',
            'version' => '系统版本',
            'feature' => '功能介绍',
            'about' => '关于我们',
            'status' => 'Status',
            'utime' => 'Utime',
            'uid' => 'Uid',
            'ctime' => 'Ctime',
            'cid' => 'Cid',
        ];
    }
}
