<?php
namespace backend\modules\member\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends \common\models\UserSearch
{


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find()->andWhere(['t.role' => self::ROLE_NORMAL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'gender' => $this->gender,
            'role' => $this->role,
            'status' => $this->status,
            'uid' => $this->uid,
            'utime' => $this->utime,
            'cid' => $this->cid,
            'ctime' => $this->ctime,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'realname', $this->realname])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'birth', $this->birth])
            ->andFilterWhere(['like', 'portrait', $this->portrait])
            ->andFilterWhere(['like', 'authkey', $this->authkey])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
