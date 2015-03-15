<?php

namespace backend\modules\order\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\order\models\Order;

/**
 * OrderSearch represents the model behind the search form about `backend\modules\order\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hosp_id', 'opera_id', 'insp_id', 'doctor_id', 'type', 'payment_method', 'payment_id', 'refund_id', 'process', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['order_no', 'opera_name', 'insp_name', 'doctor_job_title', 'doctor_name', 'address', 'date', 'start_time', 'end_time'], 'safe'],
            [['cost'], 'number'],
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
        $query = Order::find();

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
            'insp_id' => $this->insp_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'type' => $this->type,
            'payment_method' => $this->payment_method,
            'payment_id' => $this->payment_id,
            'refund_id' => $this->refund_id,
            'cost' => $this->cost,
            'process' => $this->process,
            'status' => $this->status,
            'utime' => $this->utime,
            'uid' => $this->uid,
            'ctime' => $this->ctime,
            'cid' => $this->cid,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'opera_name', $this->opera_name])
            ->andFilterWhere(['like', 'insp_name', $this->insp_name])
            ->andFilterWhere(['like', 'doctor_job_title', $this->doctor_job_title])
            ->andFilterWhere(['like', 'doctor_name', $this->doctor_name])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
