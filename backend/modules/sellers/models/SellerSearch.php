<?php

namespace backend\modules\sellers\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Seller;
use common\models\License;

/**
 * CategorySearch represents the model behind the search form about common\models\Category.
 */

class SellerSearch extends Seller
{
    //protected $activeLicense;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'website'], 'safe'],
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
        $query = Seller::find()->orderBy('name ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}
