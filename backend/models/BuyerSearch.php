<?php

namespace backend\models;

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
            [['dob', 'name', 'gender', 'email'], 'required'],
            [['buyerId', 'userId', 'dob'], 'string', 'max' => 21],
            [['about'], 'string', 'max' => 420],
            [['name'], 'string', 'max' => 80],
            [['gender'], 'string', 'max' => 3],
            [['email', 'website'], 'string', 'max' => 60],
            [['title'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 3],
        ];
    }
}
