<?php

namespace backend\modules\transactions\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;

/**
 * CategorySearch represents the model behind the search form about common\models\Category.
 */

class TransactionSearch extends Transaction
{
    //protected $activeLicense;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transactionId', 'amount', 'fee', 'timestamp', 'senderId', 'recipientId', 'tokenId', 'relationshipId', 'type'], 'safe'],
            // [['senderPublicKey'], 'string', 'max' => 64],
            // [['signature'], 'string', 'max' => 128],
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
        $query = Transaction::find()->orderBy('timestamp ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like binary', 'senderId', $this->senderId]);
        $query->andFilterWhere(['like binary', 'recipientId', $this->recipientId]);
        $query->andFilterWhere(['=', 'type', $this->type]);

        //$query->andFilterWhere(['like', 'tbl_item.categoryId', $this->item]);

        //$query->andFilterWhere(['like', 'amount', $this->amount]);
        if($this->amount == 201)
            $query->andFilterWhere(['>', 'amount', 200]);
        else
            $query->andFilterWhere(['<', 'amount', $this->amount]);

        //$query->andFilterWhere(['>', 'discountPerUnit', $this->discountPerUnit]);
        return $dataProvider;
    }
}
