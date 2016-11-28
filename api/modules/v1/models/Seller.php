<?php

namespace api\modules\v1\models;

use Yii;
use \backend\models\Picture;

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
            [['sellerId', 'userId'], 'string', 'max' => 21],
            [['about'], 'string', 'max' => 420],
            [['name', 'email', 'website'], 'string', 'max' => 60],
            [['hours', 'categories', 'paymentOptions'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
            [['pictureId'], 'exist', 'skipOnError' => true, 'targetClass' => Picture::className(), 'targetAttribute' => ['pictureId' => 'pictureId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sellerId' => 'Seller ID',
            'userId' => 'User ID',
            'pictureId' => 'Picture',
            'about' => 'About',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'cellphone' => 'Cell Phone',
            'website' => 'Website',
            'hours' => 'Hours',
            'categories' => 'Categories',
            'paymentOptions' => 'Payment Options',
        ];
    }

    public function getOffers()
    {
        return $this->hasMany(Offer::className(), ['sellerId' => 'sellerId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
    }

    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['pictureId' => 'pictureId']);
    }

    /*public function getReviewFacts()
    {
        return $this->hasMany(ReviewFact::className(), ['sellerId' => 'sellerId']);
    }*/

    public function getReviews()
    {
        return $this->hasMany(ReviewFact::className(), ['sellerId' => 'sellerId']);
            //->via('reviewFacts');
    }
}
