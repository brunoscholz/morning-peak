<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use common\models\Offer;
use api\components\RestUtils;


/**
 * OfferSearch represents the model behind the search form about common\models\Offer.
 */
class OfferModel extends Offer
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
     * @return ActiveQuery
     */
    public function search($params)
    {
        $query = Offer::find();
        $query->joinWith([
            'item'
        ]);

        // if (!($this->load($params) && $this->validate())) {
        //     return $query;
        // }

        $query->offset($params['offset']);
        $query->select($params['select']);
        if($params['sort'] == '') $params['sort'] = 'createdAt ASC, pricePerUnit ASC';
            $query->orderBy($params['sort']);
        if($params['limit'] > 0) $query->limit($params['limit']);

        foreach ($params['where'] as $field => $info) {
            if(strpos($field, "."))
                $field = "tbl_" . $field;

            if (isset($info['test']))
                $query->andFilterWhere([$info['test'], $field, $info['value']]);
            else
                $query->andFilterWhere(['like', $field, $info]);
        }

        foreach ($params['ftFilters'] as $key => $value)
        {
            $query->andWhere($key . " >= '". $v['from']."' ");
            $query->andWhere($key . " <= '". $v['to']."'");
        }

        /*$query->andFilterWhere(['like', 'tbl_item.title', $this->itemId]);
        $query->andFilterWhere(['like binary', 'sellerId', $this->sellerId]);
        $query->andFilterWhere(['like', 'tbl_item.categoryId', $this->item]);

        if($this->pricePerUnit == 201)
            $query->andFilterWhere(['>', 'pricePerUnit', 200]);
        else
            $query->andFilterWhere(['<', 'pricePerUnit', $this->pricePerUnit]);

        $query->andFilterWhere(['>', 'discountPerUnit', $this->discountPerUnit]);*/
        return $query;
    }
}
