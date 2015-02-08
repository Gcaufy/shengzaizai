<?php

namespace backend\modules\operation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\operation\models\OperationHospitalMap;

/**
 * OperationHospitalMapSearch represents the model behind the search form about `backend\modules\operation\models\OperationHospitalMap`.
 */
class OperationHospitalMapSearch extends OperationHospitalMap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hosp_id', 'opera_id', 'feedback_score', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['contact'], 'safe'],
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
        $query = OperationHospitalMap::find();

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
            'hosp_id' => $this->hosp_id,
            'opera_id' => $this->opera_id,
            'feedback_score' => $this->feedback_score,
            'status' => $this->status,
            'utime' => $this->utime,
            'uid' => $this->uid,
            'ctime' => $this->ctime,
            'cid' => $this->cid,
        ]);

        $query->andFilterWhere(['like', 'contact', $this->contact]);

        return $dataProvider;
    }
}
