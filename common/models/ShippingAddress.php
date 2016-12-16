<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shipping_address}}".
 *
 * @property string $shippingAddressId
 * @property string $adress
 * @property string $city
 * @property string $neighborhood
 * @property string $state
 * @property string $postCode
 * @property string $country
 */
class ShippingAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shipping_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shippingAddressId', 'adress', 'city', 'neighborhood', 'state', 'postCode', 'country'], 'required'],
            [['shippingAddressId'], 'string', 'max' => 21],
            [['adress', 'country'], 'string', 'max' => 100],
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
            'shippingAddressId' => 'Shipping Address ID',
            'address' => 'Endereço',
            'city' => 'Cidade',
            'neighborhood' => 'Bairro',
            'state' => 'State',
            'postCode' => 'CEP',
            'country' => 'País',
        ];
    }

    public function getFullAddress($wc = false)
    {
        return $this->address .', '. $this->neighborhood .' - '. $this->city .'/'. $this->state;
    }
}
