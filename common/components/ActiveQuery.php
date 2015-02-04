<?php

namespace common\components;

class ActiveQuery extends \yii\db\ActiveQuery
{

    public $tableAlias = 't';
    private $__active = true;

    /**
     * @inheritdoc
     */
    public function __construct($modelClass, $config = [])
    {
        parent::__construct($modelClass, $config);
        $tableName = $modelClass::tableName();
        $this->from("$tableName {$this->tableAlias}");
    }

    /**
     * @inheritdoc
     */
    public function from($tables)
    {
        if (is_string($tables) && preg_match('/^[\w_]+\s+([\w_]+)$/', $tables, $matches)) {
            if (is_array($this->where)) {
                $this->updateCondition($this->where, "{$this->tableAlias}.", "{$matches[1]}.");
            }
            $this->tableAlias = $matches[1];
        }
        return parent::from($tables);
    }

    /**
     * @inheritdoc
     */
    public function prepare($builder)
    {
        $query = parent::prepare($builder);
        if (is_array($query->join)) {
            foreach ($query->join as &$join) {
                $tables = [];
                foreach ($join[1] as $table) {
                    if (preg_match('/^(?:[^\s]+\s+)?([^\s]+)/', $table, $matches)) {
                        $tables[] = $matches[1];
                    }
                }
                $statusColumns = array_map(function($table) {
                    return "{$table}.status";
                }, $tables);
                $join[2] = ['and', $join[2], array_combine($statusColumns, array_fill(0, count($statusColumns), MyActiveRecord::STATUS_ACTIVE))];
            }
        }
        if (is_array($query->where)) {
            $modelClass = $this->modelClass;
            $tableName = $modelClass::tableName();
            $this->updateCondition($query->where, "{$tableName} {$this->tableAlias}", $this->tableAlias);
        }
        $query->andFilterWhere(["{$this->tableAlias}.status" => $this->__active]);
        return $query;
    }

    public function active($active = true)
    {
        $this->__active = $active;
        return $this;
    }

    /**
     * implement this method to define the access rule on a model
     * this is one of the default scopes of MyActiveRecord
     * @return \common\components\ActiveQuery
     */
    public function auth()
    {
        return $this;
    }

    protected function updateCondition(&$where, $before, $after)
    {
        foreach ($where as $key => $value) {
            if (is_array($value)) {
                $this->updateCondition($where[$key], $before, $after);
            } elseif (strpos($key, $before) === 0) {
                $where[str_replace($before, $after, $key)] = $where[$key];
                unset($where[$key]);
            } elseif (is_string($value) && strpos($value, $before) !== false) {
                $where[$key] = str_replace($before, $after, $value);
            }
        }
    }

}
