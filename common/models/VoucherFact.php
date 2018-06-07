<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%voucherfact}}".
 *
 * @property string $voucherFactId
 * @property string $voucherId
 * @property string $offerId
 * @property string $sellerId
 * @property string $date
 * @property string $status
 *
 * @property Seller $seller
 * @property Voucher $voucher
 * @property Offer $offer
 */
class VoucherFact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%voucherfact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voucherFactId', 'voucherId', 'date'], 'required'],
            [['date'], 'safe'],
            [['voucherFactId', 'voucherId', 'offerId', 'sellerId'], 'string', 'max' => 21],
            [['status'], 'string', 'max' => 3],
            [['sellerId'], 'unique'],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['voucherId'], 'exist', 'skipOnError' => true, 'targetClass' => Voucher::className(), 'targetAttribute' => ['voucherId' => 'voucherId']],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'voucherFactId' => 'Voucher Fact ID',
            'voucherId' => 'Voucher ID',
            'offerId' => 'Offer ID',
            'sellerId' => 'Seller ID',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'voucherFactId', $id])
            ->one();
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
    public function getVoucher()
    {
        return $this->hasOne(Voucher::className(), ['voucherId' => 'voucherId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffer()
    {
        return $this->hasOne(Offer::className(), ['offerId' => 'offerId']);
    }
}
