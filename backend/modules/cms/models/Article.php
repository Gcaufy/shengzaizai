<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "{{%cms_article}}".
 *
 * @property string $id
 * @property string $category_id
 * @property string $title
 * @property string $short
 * @property string $content
 * @property string $favor
 * @property string $positive
 * @property string $thumb
 * @property string $banner
 * @property integer $banner_position
 * @property string $from
 * @property integer $status
 * @property integer $utime
 * @property string $uid
 * @property integer $ctime
 * @property string $cid
 *
 * @property CmsCategory $category
 */
class Article extends \common\components\MyActiveRecord
 {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%cms_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'favor', 'positive', 'banner_position', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['short'], 'string', 'max' => 2000],
            [['thumb', 'banner'], 'string', 'max' => 100],
            [['from'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $arr = parent::attributeLabels();
        $arr['category_id'] = '分类ID';
        $arr['title'] = '标题';
        $arr['short'] = '摘要';
        $arr['content'] = '内容';
        $arr['favor'] = '收藏';
        $arr['positive'] = '点赞';
        $arr['thumb'] = '文章缩略图';
        $arr['banner'] = 'Banner图';
        $arr['banner_position'] = 'Banner位置';
        $arr['from'] = '来自';
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(CmsCategory::className(), ['id' => 'category_id']);
    }
}
