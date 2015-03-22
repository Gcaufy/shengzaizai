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

    public $pthumb;
    public $pbanner;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%cms_article}}';
    }

    public function init() {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['isbanner', 'category_id', 'favor', 'positive', 'banner_position', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['content'], 'string'],
            [['title', 'url'], 'string', 'max' => 200],
            [['short'], 'string', 'max' => 2000],
            [['thumb', 'banner'], 'string', 'max' => 100],
            [['from'], 'string', 'max' => 50],
            [['url'], 'unique']
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
        $arr['url'] = '自定义链接';
        $arr['pthumb'] = '文章缩略图';
        $arr['thumb'] = '文章缩略图';
        $arr['isbanner'] = '是否是Banner文章';
        $arr['banner'] = 'Banner图';
        $arr['pbanner'] = 'Banner图';
        $arr['banner_position'] = 'Banner轮播位置';
        $arr['from'] = '来自';
        return $arr;
    }


    public function getUrl() {
        if (!$this->url && $this->id)
            $this->url = Yii::$app->baseUrl . '/article?id=' . $this->id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])
            ->from(Category::tableName() . ' cateogry');
    }
}
