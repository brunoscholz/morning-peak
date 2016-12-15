<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Offer;

/**
 * OfferSearch represents the model behind the search form about common\models\Offer.
 */
class OfferSearch extends Offer
{
    public $item;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['itemId', 'item', 'sellerId', 'description', 'itemCondition', 'status', 'pricePerUnit', 'discountPerUnit'], 'safe'],
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
        $query = Offer::find()->orderBy('createdAt ASC, pricePerUnit ASC');
        $query->joinWith([
            'item'
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'tbl_item.title', $this->itemId]);
        $query->andFilterWhere(['like binary', 'sellerId', $this->sellerId]);
        $query->andFilterWhere(['like', 'tbl_item.categoryId', $this->item]);

        if($this->pricePerUnit == 201)
            $query->andFilterWhere(['>', 'pricePerUnit', 200]);
        else
            $query->andFilterWhere(['<', 'pricePerUnit', $this->pricePerUnit]);

        $query->andFilterWhere(['>', 'discountPerUnit', $this->discountPerUnit]);
        return $dataProvider;
    }
}
