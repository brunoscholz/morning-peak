<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * Seller Model
 * This is the model class for table "{{%seller}}".
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class Seller extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'ACT';
    const STATUS_NOT_VERIFIED = 'PEN';
    const STATUS_WAITING_PAY = 'PAY';
    const STATUS_BANNED = 'BAN';
    const STATUS_REMOVED = 'REM';

    public static $statusArray = [
        self::STATUS_ACTIVE,
        self::STATUS_NOT_VERIFIED,
        self::STATUS_WAITING_PAY,
        self::STATUS_BANNED,
        self::STATUS_REMOVED,
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seller}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['sellerId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sellerId', 'userId', 'name', 'email', 'phone', 'cellphone'], 'required'],
            [['sellerId', 'userId', 'pictureId', 'billingAddressId'], 'string', 'max' => 21],
            [['about'], 'string', 'max' => 420],
            [['name', 'email', 'website'], 'string', 'max' => 60],
            [['hours', 'categories', 'paymentOptions'], 'string', 'max' => 255],
            //[['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
            [['pictureId'], 'exist', 'skipOnError' => true, 'targetClass' => Picture::className(), 'targetAttribute' => ['pictureId' => 'pictureId']],
            [['billingAddressId'], 'exist', 'skipOnError' => true, 'targetClass' => BillingAddress::className(), 'targetAttribute' => ['billingAddressId' => 'billingAddressId']],
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
            'sellerId' => 'ID Prestadora',
            'userId' => 'ID Usuário',
            'pictureId' => 'Fotos',
            'about' => 'Sobre',
            'name' => 'Nome Fantasia',
            'email' => 'Email',
            'phone' => 'Fone',
            'cellphone' => 'Celular',
            'website' => 'Website',
            'hours' => 'Hours',
            'categories' => 'Categories',
            'paymentOptions' => 'Opções de Pagamento',
            'createdAt' => 'Data Criação',
            'updatedAt' => 'Data Atualização',
            'status' => 'Status',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'sellerId', $id])
            ->one();
    }

    public function getOffers()
    {
        return $this->hasMany(Offer::className(), ['sellerId' => 'sellerId']);
    }

    public function getUser() {}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['pictureId' => 'pictureId']);
    }

    public function getBillingAddress()
    {
        return $this->hasOne(BillingAddress::className(), ['billingAddressId' => 'billingAddressId']);
    }

    public function getFollowers()
    {
        return $this->hasMany(FollowFact::className(), ['sellerId' => 'sellerId']);
    }

    public function getReviews()
    {
        return $this->hasMany(ReviewFact::className(), ['sellerId' => 'sellerId']);
    }
}
