<?php

namespace api\modules\v2\models;

use Yii;
use yii\base\Model;
use common\models\Offer;
use api\components\SearchForm;
use api\components\RestUtils;


/**
 * OfferSearch represents the model behind the search form about common\models\Offer.
 */
class OfferModel extends SearchForm
{
    public $modelClass = 'common\models\Offer';

    public $item;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['itemId', 'item', 'sellerId', 'description', 'itemCondition', 'status', 'pricePerUnit', 'discountPerUnit'], 'safe'],
        ]);
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function attributeLabels()
    {
        return \yii\helpers\ArrayHelper::merge(parent::attributeLabels(), [
            // HERE PUT YOUR LABELS FOR ATTRIBUTES
        ]);
    }

    public function filterAttributes()
    {
        parent::filterAttributes();
        // HERE type your filter rules, like:
        // $this->query->andFilterWhere(['like', 'attribute', $this->attribute]);
        
        // foreach ($this->params['ftFilters'] as $key => $value)
        // {
        //     $query->andWhere($key . " >= '". $v['from']."' ");
        //     $query->andWhere($key . " <= '". $v['to']."'");
        // }
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveQuery
     */
    public function search($get)
    {
        $params = RestUtils::getQueryParams($get);
        $query = $this->buildQuery($params);
        $query->joinWith([
            'item'
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $query;
        }

        $query->select($params['select']);
        $query->offset($get['offset']);
        if($get['limit'] > 0) $query->limit($get['limit']);
        if($params['sort'] == '') $params['sort'] = 'createdAt ASC, pricePerUnit ASC';
            $query->orderBy($params['sort']);

        /*foreach ($params['ftFilters'] as $key => $value)
        {
            $query->andWhere($key . " >= '". $v['from']."' ");
            $query->andWhere($key . " <= '". $v['to']."'");
        }*/

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
