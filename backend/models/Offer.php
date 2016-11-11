<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

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
 * @property string $pictureId
 * @property string $keywords
 * @property string $itemCondition
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
     * @var UploadedFile[]
     */
    public $imageCover;
    public $imageThumb;

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
            [['itemId', 'policyId', 'pricePerUnit', 'description', 'itemCondition'], 'required'],
            [['pricePerUnit', 'discountPerUnit'], 'number'],
            [['offerId', 'itemId', 'policyId', 'shippingId'], 'string', 'max' => 21],
            [['description'], 'string', 'max' => 255],
            [['itemCondition', 'status'], 'string', 'max' => 3],
            [['shippingId'], 'exist', 'skipOnError' => true, 'targetClass' => Shipping::className(), 'targetAttribute' => ['shippingId' => 'shippingId']],
            [['itemId'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['itemId' => 'itemId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['policyId'], 'exist', 'skipOnError' => true, 'targetClass' => Policy::className(), 'targetAttribute' => ['policyId' => 'policyId']],
            [['pictureId'], 'exist', 'skipOnError' => true, 'targetClass' => Picture::className(), 'targetAttribute' => ['pictureId' => 'pictureId']],
            //[['imageHashes', 'keywords'], 'string'],
            [['imageCover'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageThumb'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
                'value' => new Expression('NOW()'),
            ],
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
            'policyId' => 'Termos de Uso',
            'shippingId' => 'ID Entrega',
            'pictureId' => 'PictureID',
            'pricePerUnit' => 'Preço por Unidade',
            'discountPerUnit' => 'Desconto por Unidade',
            'description' => 'Descrição',
            //'imageHashes' => 'Imagens',
            'keywords' => 'Palavras Chave',
            'itemCondition' => 'Condição',
            'createdAt' => 'Data Criação',
            'updatedAt' => 'Data Atualização',
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

    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['pictureId' => 'pictureId']);
    }
}
