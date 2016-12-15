<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%billing_address}}".
 *
 * @property string $billingAddressId
 * @property string $address
 * @property string $city
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
            [['billingAddressId', 'address', 'city', 'state', 'postCode', 'country'], 'required'],
            [['billingAddressId'], 'string', 'max' => 21],
            [['address', 'country'], 'string', 'max' => 100],
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
            'billingAddressId' => 'Billing Address ID',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'postCode' => 'Post Code',
            'country' => 'Country',
        ];
    }
}
