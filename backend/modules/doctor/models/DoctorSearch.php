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
            [['id', 'hosp_id', 'feedback_manner', 'feedback_effect', 'order_num', 'active_order_num', 'isvip', 'type', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
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
            't.id' => $this->id,
            't.hosp_id' => $this->hosp_id,
            't.feedback_manner' => $this->feedback_manner,
            't.feedback_effect' => $this->feedback_effect,
            't.normal_reg_cost' => $this->normal_reg_cost,
            't.expert_reg_cost' => $this->expert_reg_cost,
            't.order_num' => $this->order_num,
            't.active_order_num' => $this->active_order_num,
            't.isvip' => $this->isvip,
            't.type' => $this->type,
            't.status' => $this->status,
            't.utime' => $this->utime,
            't.uid' => $this->uid,
            't.ctime' => $this->ctime,
            't.cid' => $this->cid,
        ]);

        $query->andFilterWhere(['like', 't.name', $this->name])
            ->andFilterWhere(['like', 't.desc', $this->desc])
            ->andFilterWhere(['like', 't.major', $this->major])
            ->andFilterWhere(['like', 't.experience', $this->experience])
            ->andFilterWhere(['like', 't.note', $this->note]);

        return $dataProvider;
    }
}
