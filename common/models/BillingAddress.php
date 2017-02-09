<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%billing_address}}".
 *
 * @property string $billingAddressId
 * @property string $address
 * @property string $streetNumber
 * @property string $formattedAddress
 * @property string $city
 * @property string $neighborhood
 * @property string $state
 * @property string $postCode
 * @property string $country
 * @property double $latitude
 * @property double $longitude
 * @property string $status
 *
 * @property Buyer[] $buyers
 * @property Seller[] $sellers
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
            [['billingAddressId', 'address', 'city', 'neighborhood', 'state', 'latitude', 'longitude'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['billingAddressId'], 'string', 'max' => 21],
            [['address', 'formattedAddress'], 'string', 'max' => 100],
            [['streetNumber'], 'string', 'max' => 6],
            [['city', 'neighborhood', 'country'], 'string', 'max' => 60],
            [['state'], 'string', 'max' => 2],
            [['postCode'], 'string', 'max' => 15],
            [['status'], 'string', 'max' => 3],
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
            'streetNumber' => 'Número',
            'formattedAddress' => 'Endereço Formatado',
            'city' => 'Cidade',
            'neighborhood' => 'Bairro',
            'state' => 'UF',
            'postCode' => 'CEP',
            'country' => 'País',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'status' => 'Status',
        ];
    }

    public function getFullAddress()
    {
        return $this->address . ', ' . $this->streetNumber;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyers()
    {
        return $this->hasMany(Buyer::className(), ['billingAddressId' => 'billingAddressId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellers()
    {
        return $this->hasMany(Seller::className(), ['billingAddressId' => 'billingAddressId']);
    }
}
