<?php

namespace common\components;

use Yii;
use yii\base\UnknownPropertyException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\User;

class MyActiveRecord extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    protected $_initColumn = true;

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (UnknownPropertyException $e) {
            Yii::$app->db->schema->refresh();
            return parent::__get($name);
        }
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (UnknownPropertyException $e) {
            Yii::$app->db->schema->refresh();
            parent::__set($name, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //$this->loadDefaultValues();
        $this->initColumn();
    }

    protected function initColumn() {
        if (!$this->_initColumn)
            return;
        $this->on(self::EVENT_BEFORE_INSERT, function ($event) {
            $userId = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->id;
            if ($this->hasAttribute('cid'))
                $this->cid = $userId;
            if ($this->hasAttribute('uid'))
                $this->uid = $userId;
            if ($this->hasAttribute('utime'))
                $this->utime = time();
            if ($this->hasAttribute('ctime'))
                $this->ctime = time();
        });
        $this->on(self::EVENT_BEFORE_UPDATE, function ($event) {
            $userId = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->id;
            if ($this->hasAttribute('uid'))
                $this->uid = $userId;
            if ($this->hasAttribute('utime'))
                $this->utime = time();
        });
    }


    public static function createQuery()
    {
        return parent::createQuery()->andWhere(['t.status' => 1]);
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
    protected static function findByCondition($condition)
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

        return $query->andWhere($condition);
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

    public function getCreatedBy()
    {
        return $this->hasAttribute('cid') ?
            $this->hasOne(User::className(), ['id' => 'cid'])->from(User::tableName() . ' created_by') :
            null;
    }

    public function getUpdatedBy()
    {
        return $this->hasAttribute('uid') ?
            $this->hasOne(User::className(), ['id' => 'uid'])->from(User::tableName() . ' updated_by') :
            null;
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


    public function attributeLabels() {
        $arr = [];
        $arr['id'] = 'ID';
        $arr['status'] = '状态';
        $arr['ctime'] = '创建时间';
        $arr['utime'] = '更新时间';
        $arr['cid'] = '创建ID';
        $arr['uid'] = '更新时间';
        return $arr;
    }
}
