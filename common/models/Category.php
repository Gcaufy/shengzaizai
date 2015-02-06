<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cms_category}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 *
 * @property CmsArticle[] $cmsArticles
 */
class Category extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
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
    public function getCmsArticles()
    {
        return $this->hasMany(CmsArticle::className(), ['category_id' => 'id']);
    }
}
