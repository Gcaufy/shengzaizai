<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "szz_cms_article_positive".
 *
 * @property string $id
 * @property string $ip
 * @property string $article_id
 * @property integer $status
 * @property string $cid
 * @property string $ctime
 *
 * @property CmsArticle $article
 */
class ArticlePositive extends \common\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'szz_cms_article_positive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'article_id', 'status', 'cid', 'ctime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'article_id' => 'Article ID',
            'status' => 'Status',
            'cid' => 'Cid',
            'ctime' => 'Ctime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(CmsArticle::className(), ['id' => 'article_id']);
    }
}
