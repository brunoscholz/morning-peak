<?php

namespace api\modules\v2\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Category as CategoryModel;

/**
 * Category represents the model behind the api requests about common\models\Categories.
 */
class Category extends CategoryModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryId', 'name', 'description'], 'safe'],
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
        //$filters = ['Category' => (array)json_decode($params['q'], true)];
        $query = CategoryModel::find()->orderBy('name ASC');

        if (!($this->load($params) && $this->validate())) {
            return $query;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like binary', 'categoryId', $this->categoryId]);
        $query->andFilterWhere(['like', 'description', $this->description]);

        return $query;
    }
}
