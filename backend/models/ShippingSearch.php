<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%shipping}}".
 *
 * @property string $shippingId
 * @property string $regions
 * @property string $estimateDelivery
 * @property string $origins
 * @property double $fee
 * @property integer $free
 *
 * @property Offer[] $offers
 */
class Shipping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shipping}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shippingId', 'regions', 'estimateDelivery', 'origins', 'fee', 'free'], 'required'],
            [['regions', 'estimateDelivery', 'origins'], 'string'],
            [['fee'], 'number'],
            [['free'], 'integer'],
            [['shippingId'], 'string', 'max' => 21],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shippingId' => 'Shipping ID',
            'regions' => 'Regions',
            'estimateDelivery' => 'Estimate Delivery',
            'origins' => 'Origins',
            'fee' => 'Fee',
            'free' => 'Free',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffers()
    {
        return $this->hasMany(Offer::className(), ['shippingId' => 'shippingId']);
    }
}
