<?php

namespace backend\modules\buyers\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Buyer;

/**
 * BuyerSearch represents the model behind the search form about common\models\Buyer.
 */
class BuyerSearch extends Buyer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'gender', 'dob', 'status'], 'safe'],
        ];
    }

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
        $query = Buyer::find()->orderBy('name ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if(isset($params['role'])) {
            $query->join('JOIN', 'tbl_user', 'tbl_user.buyerId = tbl_buyer.buyerId');
            $query->andFilterWhere(['tbl_user.role' => $params['role']]);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'tbl_buyer.name', $this->name]);
        $query->andFilterWhere(['like', 'tbl_buyer.email', $this->email]);

        return $dataProvider;
    }
}
