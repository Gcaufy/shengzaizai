<?php

namespace backend\modules\hospital\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\hospital\models\Hospital;

/**
 * HospitalSearch represents the model behind the search form about `backend\modules\hospital\models\Hospital`.
 */
class HospitalSearch extends Hospital
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'region_id', 'opened_order', 'active_opened_order', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['name', 'addr', 'tel', 'longitude', 'latitude'], 'safe'],
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
        $query = Hospital::find();

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
            'region_id' => $this->region_id,
            'opened_order' => $this->opened_order,
            'active_opened_order' => $this->active_opened_order,
            'status' => $this->status,
            'utime' => $this->utime,
            'uid' => $this->uid,
            'ctime' => $this->ctime,
            'cid' => $this->cid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'addr', $this->addr])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'latitude', $this->latitude]);

        return $dataProvider;
    }
}
