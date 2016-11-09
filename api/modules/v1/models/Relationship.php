<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%relationship}}".
 *
 * @property string $relationshipId
 * @property string $referenceId
 * @property string $offerId
 * @property integer $dateId
 * @property string $sellerId
 * @property string $buyerId
 * @property string $shippingAddress
 * @property string $loyaltyId
 */
class Relationship extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%relationship}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relationshipId', 'referenceId', 'offerId', 'dateId', 'sellerId', 'buyerId', 'shippingAddress', 'loyaltyId'], 'required'],
            [['dateId'], 'integer'],
            [['relationshipId', 'referenceId', 'offerId', 'sellerId', 'buyerId', 'shippingAddress', 'loyaltyId'], 'string', 'max' => 21],
            [['loyaltyId'], 'exist', 'skipOnError' => true, 'targetClass' => Loyalty::className(), 'targetAttribute' => ['loyaltyId' => 'loyaltyId']],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
            [['dateId'], 'exist', 'skipOnError' => true, 'targetClass' => Date::className(), 'targetAttribute' => ['dateId' => 'dateId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'relationshipId' => 'Relationship ID',
            'referenceId' => 'Reference ID',
            'offerId' => 'Offer ID',
            'dateId' => 'Date ID',
            'sellerId' => 'Seller ID',
            'buyerId' => 'Buyer ID',
            'shippingAddress' => 'Shipping Address',
            'loyaltyId' => 'Loyalty ID',
        ];
    }

    public function getLoyalty()
    {
        return $this->hasOne(Loyalty::className(), ['loyaltyId' => 'loyaltyId'])
            ->with(['buyer', 'transaction']);
    }

    public function getOffer()
    {
        return $this->hasOne(Offer::className(), ['offerId' => 'offerId']);
    }

    public function getDate()
    {
        return $this->hasOne(Date::className(), ['dateId' => 'dateId']);
    }

    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['sellerId' => 'sellerId']);
    }

    public function getBuyer()
    {
        return $this->hasOne(Buyer::className(), ['buyerId' => 'buyerId']);
    }
}
