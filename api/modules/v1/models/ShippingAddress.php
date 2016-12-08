<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%shipping_address}}".
 *
 * @property string $shippingAddressId
 * @property string $adress
 * @property string $city
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
            [['shippingAddressId', 'adress', 'city', 'state', 'postCode', 'country'], 'required'],
            [['shippingAddressId'], 'string', 'max' => 21],
            [['adress', 'country'], 'string', 'max' => 100],
            [['city'], 'string', 'max' => 60],
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
            'adress' => 'Adress',
            'city' => 'City',
            'state' => 'State',
            'postCode' => 'Post Code',
            'country' => 'Country',
        ];
    }
}
