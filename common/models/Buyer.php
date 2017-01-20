<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * Buyer Model
 * This is the model class for table "{{%buyer}}".
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class Buyer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%buyer}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['buyerId'];
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
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['buyerId', 'name'], 'required'],
            [['buyerId', 'dob', 'pictureId', 'shippingAddressId', 'billingAddressId'], 'string', 'max' => 21],
            [['about'], 'string', 'max' => 420],
            [['name'], 'string', 'max' => 80],
            [['username'], 'string', 'max' => 21],
            [['gender', 'status'], 'string', 'max' => 3],
            [['email', 'website'], 'string', 'max' => 60],
            [['title'], 'string', 'max' => 10],
            //[['email'], 'email'],
            //[['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
            [['pictureId'], 'exist', 'skipOnError' => true, 'targetClass' => Picture::className(), 'targetAttribute' => ['pictureId' => 'pictureId']],
            [['shippingAddressId'], 'exist', 'skipOnError' => true, 'targetClass' => ShippingAddress::className(), 'targetAttribute' => ['shippingAddressId' => 'shippingAddressId']],
            [['billingAddressId'], 'exist', 'skipOnError' => true, 'targetClass' => BillingAddress::className(), 'targetAttribute' => ['billingAddressId' => 'billingAddressId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'buyerId' => 'ID Buyer',
            'pictureId' => 'Picture',
            'about' => 'Sobre',
            'dob' => 'Data de Nascimento',
            'name' => 'Nome',
            'username' => 'Nome de Usuário',
            'gender' => 'Gênero',
            'email' => 'Email',
            'title' => 'Title',
            'phone' => 'Fone',
            'website' => 'Website',
            'coinsBalance' => 'Balanço de Moedas',
            'status' => 'Status',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'buyerId', $id])
            ->one();
    }

    /*public static function findByUserId($id)
    {
        return static::find()
            ->where(['like binary', 'userId', $id])
            ->one();
    }*/

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

    public function getShippingAddress()
    {
        return $this->hasOne(ShippingAddress::className(), ['shippingAddressId' => 'shippingAddressId']);
    }

    public function getFollowers()
    {
        return $this->hasMany(FollowFact::className(), ['buyerId' => 'buyerId']);
    }

    public function getFollowing()
    {
        return $this->hasMany(FollowFact::className(), ['userId' => 'buyerId']);
    }

    public function getFavorites()
    {
        return $this->hasMany(FavoriteFact::className(), ['buyerId' => 'buyerId']);
    }

    public function getLoyalties()
    {
        return $this->hasMany(Loyalty::className(), ['buyerId' => 'buyerId']);
    }

    public function getReviews()
    {
        return $this->hasMany(ReviewFact::className(), ['buyerId' => 'buyerId']);
    }
}
