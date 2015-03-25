<?php

namespace backend\modules\inspection\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\inspection\models\InspectionHospitalMap;

/**
 * InspectionHospitalMapSearch represents the model behind the search form about `backend\modules\inspection\models\InspectionHospitalMap`.
 */
class InspectionHospitalMapSearch extends InspectionHospitalMap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'insp_id', 'hosp_id', 'feedback_manner', 'feedback_effect', 'isleaf', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
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
        $query = InspectionHospitalMap::find();

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
            'insp_id' => $this->insp_id,
            'hosp_id' => $this->hosp_id,
            'feedback_manner' => $this->feedback_manner,
            'feedback_effect' => $this->feedback_effect,
            'isleaf' => $this->isleaf,
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
