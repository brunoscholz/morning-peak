<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%relationship}}".
 *
 * @property string $relationshipId
 * @property string $referenceId
 * @property string $offerId
 * @property string $dateId
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
    public static function primaryKey()
    {
        return ['relationshipId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relationshipId', 'dateId', 'sellerId', 'buyerId', 'loyaltyId'], 'required'],
            [['dateId'], 'safe'],
            [['relationshipId', 'referenceId', 'offerId', 'sellerId', 'buyerId', 'shippingAddress', 'loyaltyId'], 'string', 'max' => 21],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['loyaltyId'], 'exist', 'skipOnError' => true, 'targetClass' => Loyalty::className(), 'targetAttribute' => ['loyaltyId' => 'loyaltyId']],
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

    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['sellerId' => 'sellerId']);
    }

    public function getBuyer()
    {
        return $this->hasOne(Buyer::className(), ['buyerId' => 'buyerId']);
    }
}
