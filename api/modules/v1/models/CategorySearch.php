<?php

namespace api\modules\v1\models;

use Yii;
use api\components\SearchForm;
use yii\data\ActiveDataProvider;
use common\models\Category;

/**
 * CategorySearch represents the model behind the search form about common\models\Category.
 */
class CategorySearch extends SearchForm
{
    public $modelClass = "common\models\Category";
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['name', 'description', 'parentId'], 'safe'],
        ];

        return array_merge(parent::rules(), $rules);
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return parent::scenarios();
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
        $query = Category::find()->orderBy('name ASC')
            ->andWhere(['<>', 'parentId', 'NULL']);
            //->andWhere(['status' => 'ACT']);
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
