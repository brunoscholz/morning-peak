<?php

namespace api\modules\v2\models;

use Yii;
use yii\base\Model;
use common\models\Offer as OfferModel;

/**
 * Offer represents the model behind the api requests about common\models\Offer.
 */
class Offer extends OfferModel
{
    public $item;
    public $seller;
    public $categoryId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryId', 'itemId', 'item', 'sellerId', 'seller', 'description', 'keywords', 'itemCondition', 'status', 'pricePerUnit', 'discountPerUnit', 'shippingId', 'policyId'], 'safe'],
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
     * @return ActiveQuery
     */
    public function search($params)
    {
        //$filters = ['Category' => (array)json_decode($params['q'], true)];
        $query = OfferModel::find()->orderBy('tbl_offer.createdAt ASC, tbl_offer.pricePerUnit ASC');
        $query->joinWith([
            'item',
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $query;
        }

        $query->andFilterWhere(['like', 'tbl_item.title', $this->item]);
        $query->andFilterWhere(['like', 'tbl_item.itemId', $this->itemId]);
        $query->andFilterWhere(['like', 'tbl_item.categoryId', $this->categoryId]);
        $query->andFilterWhere(['like binary', 'sellerId', $this->sellerId]);

        if($this->pricePerUnit == 201)
            $query->andFilterWhere(['>', 'pricePerUnit', 200]);
        else
            $query->andFilterWhere(['<', 'pricePerUnit', $this->pricePerUnit]);

        $query->andFilterWhere(['>', 'discountPerUnit', $this->discountPerUnit]);

        return $query;
    }
}
