<?php

namespace common\models;

use Yii;
use \common\models\VoucherFact;
use \common\models\ActionReference;

/**
 * This is the model class for table "{{%relationship}}".
 *
 * @property string $relationshipId
 * @property integer $actionReferenceId
 * @property string $referenceId
 * @property string $offerId
 * @property integer $dateId
 * @property string $sellerId
 * @property string $buyerId
 * @property string $voucherFactId
 * @property string $shippingAddress
 * @property string $transactionId
 *
 * @property Referencetransaction[] $referencetransactions
 * @property Voucher $voucher
 * @property Offer $offer
 * @property Seller $seller
 * @property Buyer $buyer
 * @property Transaction $transaction
 * @property Actionreference $actionReference
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
            [['relationshipId', 'actionReferenceId', 'dateId', 'sellerId', 'buyerId', 'transactionId'], 'required'],
            [['actionReferenceId', 'dateId'], 'integer'],
            [['relationshipId', 'referenceId', 'offerId', 'sellerId', 'buyerId', 'voucherFactId', 'shippingAddress', 'transactionId'], 'string', 'max' => 21],
            [['voucherFactId'], 'exist', 'skipOnError' => true, 'targetClass' => VoucherFact::className(), 'targetAttribute' => ['voucherFactId' => 'voucherFactId']],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['transactionId'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::className(), 'targetAttribute' => ['transactionId' => 'transactionId']],
            [['actionReferenceId'], 'exist', 'skipOnError' => true, 'targetClass' => ActionReference::className(), 'targetAttribute' => ['actionReferenceId' => 'actionReferenceId']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['relationshipId', 'actionReferenceId', 'dateId'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'relationshipId' => 'Relationship ID',
            'actionReferenceId' => 'Action Reference ID',
            'referenceId' => 'Reference ID',
            'offerId' => 'Offer ID',
            'dateId' => 'Date ID',
            'sellerId' => 'Seller ID',
            'buyerId' => 'Buyer ID',
            'voucherFactId' => 'Voucher ID',
            'shippingAddress' => 'Shipping Address',
            'transactionId' => 'Transaction ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferencetransactions()
    {
        return $this->hasMany(Referencetransaction::className(), ['relationshipId' => 'relationshipId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoucherfact()
    {
        return $this->hasOne(VoucherFact::className(), ['voucherFactId' => 'voucherFactId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffer()
    {
        return $this->hasOne(Offer::className(), ['offerId' => 'offerId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['sellerId' => 'sellerId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(Buyer::className(), ['buyerId' => 'buyerId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['transactionId' => 'transactionId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionreference()
    {
        return $this->hasOne(ActionReference::className(), ['actionReferenceId' => 'actionReferenceId']);
    }
}
