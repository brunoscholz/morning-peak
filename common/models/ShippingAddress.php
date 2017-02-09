<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shipping_address}}".
 *
 * @property string $shippingAddressId
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
            [['shippingAddressId', 'address', 'streetNumber', 'formattedAddress', 'city', 'neighborhood', 'state', 'postCode', 'country', 'latitude', 'longitude'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['shippingAddressId'], 'string', 'max' => 21],
            [['address', 'formattedAddress', 'country'], 'string', 'max' => 100],
            [['streetNumber'], 'string', 'max' => 6],
            [['city', 'neighborhood'], 'string', 'max' => 60],
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
            'shippingAddressId' => 'Shipping Address ID',
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
        return $this->hasMany(Buyer::className(), ['shippingAddressId' => 'shippingAddressId']);
    }
}
