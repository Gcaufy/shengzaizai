<?php

namespace backend\modules\doctor\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\doctor\models\Doctor;

/**
 * DoctorSearch represents the model behind the search form about `backend\modules\doctor\models\Doctor`.
 */
class DoctorSearch extends Doctor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hosp_id', 'feedback_score', 'order_num', 'active_order_num', 'isvip', 'type', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['name', 'desc', 'major', 'experience', 'note'], 'safe'],
            [['normal_reg_cost', 'expert_reg_cost'], 'number'],
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
        //$query = Doctor::find()->joinWith('hospital');

        //$query = Doctor::find()->joinWith(['hospital' => function ($q) { $q->from(\backend\modules\hospital\models\Hospital::tableName() . ' u'); }]);
        $query = Doctor::find()->joinWith('hospital');

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
            'feedback_score' => $this->feedback_score,
            'normal_reg_cost' => $this->normal_reg_cost,
            'expert_reg_cost' => $this->expert_reg_cost,
            'order_num' => $this->order_num,
            'active_order_num' => $this->active_order_num,
            'isvip' => $this->isvip,
            'type' => $this->type,
            'status' => $this->status,
            'utime' => $this->utime,
            'uid' => $this->uid,
            'ctime' => $this->ctime,
            'cid' => $this->cid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'major', $this->major])
            ->andFilterWhere(['like', 'experience', $this->experience])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
