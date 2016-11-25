<?php

namespace api\modules\v1\models;

use Yii;
use \backend\models\Picture;

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
 
    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['buyerId', 'userId', 'about', 'dob', 'name', 'gender', 'email', 'title', 'website'], 'required'],
            [['buyerId', 'userId', 'dob'], 'string', 'max' => 21],
            [['about'], 'string', 'max' => 420],
            [['name'], 'string', 'max' => 80],
            [['gender', 'status'], 'string', 'max' => 3],
            [['email', 'website'], 'string', 'max' => 60],
            [['title'], 'string', 'max' => 10],
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
            'buyerId' => 'Buyer ID',
            'userId' => 'User ID',
            'pictureId' => 'Picture',
            'about' => 'About',
            'dob' => 'Birthday',
            'name' => 'Name',
            'gender' => 'Gender',
            'email' => 'Email',
            'title' => 'Title',
            'website' => 'Website',
            'coinsBalance' => 'Coins Balance',
            'status' => 'Status',
        ];
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

    public function getLoyalties()
    {
        return $this->hasMany(Loyalty::className(), ['buyerId' => 'buyerId']);
    }

    public function getReviews()
    {
        return $this->hasMany(ReviewFact::className(), ['buyerId' => 'buyerId']);
    }
}
