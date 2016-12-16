<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%billing_address}}".
 *
 * @property string $billingAddressId
 * @property string $address
 * @property string $city
 * @property string $neighborhood
 * @property string $state
 * @property string $postCode
 * @property string $country
 */
class BillingAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%billing_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['billingAddressId', 'address', 'city', 'neighborhood', 'state', 'postCode', 'country'], 'required'],
            [['billingAddressId'], 'string', 'max' => 21],
            [['address', 'country'], 'string', 'max' => 100],
            [['city', 'neighborhood'], 'string', 'max' => 60],
            [['state'], 'string', 'max' => 2],
            [['postCode'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'billingAddressId' => 'Billing Address ID',
            'address' => 'Endereço',
            'city' => 'Cidade',
            'neighborhood' => 'Bairro',
            'state' => 'State',
            'postCode' => 'CEP',
            'country' => 'País',
        ];
    }

    public function getFullAddress()
    {
        return $this->address .', '. $this->neighborhood .' - '. $this->city .'/'. $this->state;
    }
}
