<?php

namespace backend\modules\system\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\system\models\Region;

/**
 * RegionSearch represents the model behind the search form about `backend\modules\system\models\Region`.
 */
class RegionSearch extends Region
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'parent_id', 'level', 'isleaf', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['longitude', 'latitude'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Region::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
            'isleaf' => $this->isleaf,
            'status' => $this->status,
            'utime' => $this->utime,
            'uid' => $this->uid,
            'ctime' => $this->ctime,
            'cid' => $this->cid,
        ]);

        $query->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'latitude', $this->latitude]);

        return $dataProvider;
    }
}
