<?php

namespace common\components;

use Yii;

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
        // If it has tablePrefix, it should like {{%user}} t
        if (is_string($tables) && preg_match('/(^[\w_]+\s+([\w_]+)$)|(^{{%[\w_]+}}\s+([\w_]+)$)/', $tables, $matches)) {
            $alias = (count($matches) == 5) ? $matches[4] : $matches[2];
            if (is_array($this->where)) {
                $this->updateCondition($this->where, "{$this->tableAlias}.", "$alias.");
            }
            if (is_array($this->on)) {
                $this->updateCondition($this->on, "{$this->tableAlias}.", "$alias.");
            }
            $this->tableAlias = $alias;
        }
        return parent::from($tables);
    }

    /**
     * @inheritdoc
     */
    public function prepare($builder)
    {
        $query = parent::prepare($builder);

        // No need to generate active condition for the join part
        if (false && is_array($query->join)) {
            $allTables = [$this->tableAlias];
            foreach ($query->join as $i => &$join) {
                $tables = [];
                foreach ((array) $join[1] as $table) {
                    if (preg_match('/^(?:([^\s]+)\s+)?([^\s]+)/', $table, $matches)) {
                        if (in_array($matches[2], $allTables)) {
                            // do not join to a table which is already in the query
                            unset($query->join[$i]);
                            continue 2;
                        } else {
                            $tables[$matches[1]] = $matches[2];
                            $allTables[] = $matches[2];
                        }
                    }
                }
                // join to active members only by default
                $statusCondition = [];
                foreach ($tables as $name => $alias) {
                    if ($name === '')
                        $name = $alias;
                    $tableSchema = Yii::$app->db->getTableSchema($name);
                    if ($tableSchema !== null && $tableSchema->getColumn('status') !== null) {
                        $statusCondition["{$alias}.status"] = MyActiveRecord::STATUS_ACTIVE;
                    }
                }
                if (count($statusCondition) > 0) {
                    $join[2] = ['and', $join[2], $statusCondition];
                }
            }
        }
        if (is_array($query->where)) {
            $modelClass = $this->modelClass;
            $tableName = $modelClass::tableName();
            $this->updateCondition($query->where, "{$tableName} {$this->tableAlias}", $this->tableAlias);
        }
        $modelClass = $this->modelClass;
        $model = new $modelClass();
        if ($model->hasAttribute('status'))
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
