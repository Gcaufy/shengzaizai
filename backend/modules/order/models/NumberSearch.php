<?php

namespace backend\modules\order\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\order\models\Number;

/**
 * NumberSearch represents the model behind the search form about `backend\modules\order\models\Number`.
 */
class NumberSearch extends Number
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hosp_id', 'opera_id', 'insp_id', 'doctor_id', 'order_num', 'active_order_num', 'type', 'status', 'utime', 'uid', 'ctime', 'cid'], 'integer'],
            [['date', 'start_time', 'end_time'], 'safe'],
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
    public function search($query = null)
    {
        if (!$query)
            $query = Number::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
            'order_num' => $this->order_num,
            'active_order_num' => $this->active_order_num,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'isvip' => $this->isvip,
            'cost' => $this->cost,
            'status' => $this->status,
            'utime' => $this->utime,
            'uid' => $this->uid,
            'ctime' => $this->ctime,
            'cid' => $this->cid,
        ]);

        return $dataProvider;
    }

    public static function buildQuery($ptype, $pid, $hosp_id) {
        $query = Number::find();
        if ($ptype && $pid && $hosp_id) {
            $query = $query->andWhere(['t.hosp_id' => $hosp_id]);
            switch ($ptype) {
                case Order::TYPE_OPERATION:
                    $query = $query->andWhere(['t.opera_id' => $pid]);
                    break;
                case Order::TYPE_INSPECTION:
                    $query = $query->andWhere(['t.insp_id' => $pid]);
                    break;
                case Order::TYPE_DOCTOR:
                    $query = $query->andWhere(['t.doctor_id' => $pid]);
                    break;
            }
        }
        return $query;
    }

}
