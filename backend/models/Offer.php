<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%offer}}".
 *
 * @property string $offerId
 * @property string $itemId
 * @property string $policyId
 * @property string $shippingId
 * @property double $pricePerUnit
 * @property double $discountPerUnit
 * @property string $description
 * @property string $imageHashes
 * @property string $keywords
 * @property string $condition
 * @property string $status
 *
 * @property Shipping $shipping
 * @property Item $item
 * @property Seller $seller
 * @property Policy $policy
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%offer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['itemId', 'policyId', 'shippingId', 'pricePerUnit', 'description', 'imageHashes', 'keywords', 'condition'], 'required'],
            [['pricePerUnit', 'discountPerUnit'], 'number'],
            [['imageHashes', 'keywords'], 'string'],
            [['offerId', 'itemId', 'policyId', 'shippingId'], 'string', 'max' => 21],
            [['description'], 'string', 'max' => 255],
            [['condition', 'status'], 'string', 'max' => 3],
            [['shippingId'], 'exist', 'skipOnError' => true, 'targetClass' => Shipping::className(), 'targetAttribute' => ['shippingId' => 'shippingId']],
            [['itemId'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['itemId' => 'itemId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['policyId'], 'exist', 'skipOnError' => true, 'targetClass' => Policy::className(), 'targetAttribute' => ['policyId' => 'policyId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'offerId' => 'ID Oferta',
            'itemId' => 'ID Item',
            'sellerId' => 'ID Prestadora',
            'policyId' => 'ID Termos',
            'shippingId' => 'ID Entrega',
            'pricePerUnit' => 'Preço por Unidade',
            'discountPerUnit' => 'Desconto por Unidade',
            'description' => 'Descrição',
            'imageHashes' => 'Imagens',
            'keywords' => 'Palavras Chave',
            'condition' => 'Condição',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipping()
    {
        return $this->hasOne(Shipping::className(), ['shippingId' => 'shippingId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['itemId' => 'itemId']);
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
    public function getPolicy()
    {
        return $this->hasOne(Policy::className(), ['policyId' => 'policyId']);
    }
}
