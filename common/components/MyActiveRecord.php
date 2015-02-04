<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

class MyActiveRecord extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['ctime', 'utime'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['utime'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find($className = 'common\components\ActiveQuery')
    {
        $tableName = static::tableName();
        return Yii::createObject($className, [get_called_class()])->active()->auth();
    }

    /**
     * @inheritdoc
     */
    protected static function findByCondition($condition, $one)
    {
        $query = static::find();

        if (!ArrayHelper::isAssociative($condition)) {
            // query by primary key
            $primaryKey = static::primaryKey();
            if (isset($primaryKey[0])) {
                $pk = $primaryKey[0];
                if (!empty($query->join) || !empty($query->joinWith)) {
                    /**
                     * @see \yii\db\ActiveRecord::findByCondition
                     */
                    $pk = $query->tableAlias . '.' . $pk;
                }
                $condition = [$pk => $condition];
            } else {
                throw new InvalidConfigException('"' . get_called_class() . '" must have a primary key.');
            }
        }

        return $one ? $query->andWhere($condition)->one() : $query->andWhere($condition)->all();
    }

    /**
     * @inheritdoc
     */
    public static function deleteAll($condition = '', $params = [])
    {
        $command = static::getDb()->createCommand();
        $command->update(static::tableName(), ['status' => self::STATUS_DELETED], $condition, $params);

        return $command->execute();
    }

    public function formatDate($time)
    {
        $t = time() - $this->$time;
        $f = array(
            '31536000'=>'年',
            '2592000'=>'个月',
            '604800'=>'星期',
            '86400'=>'天',
            '3600'=>'小时',
            '60'=>'分钟',
            '1'=>'秒'
        );
        foreach ($f as $k=>$v)    {
            if (0 !=$c=floor($t/(int)$k)) {
                return $c.$v.'前';
            }
        }
    }
}
