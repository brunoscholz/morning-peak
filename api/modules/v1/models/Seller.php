<?php

namespace api\modules\v1\models;

use Yii;
use \backend\models\Picture;

/**
 * This is the model class for table "{{%seller}}".
 *
 * @property string $sellerId
 * @property string $userId
 * @property string $about
 * @property string $name
 * @property string $email
 * @property string $website
 * @property string $facebookSocialId
 * @property string $twitterSocialId
 * @property string $instagramSocialId
 * @property string $snapchatSocialId
 * @property string $linkedinSocialId
 * @property string $githubSocialId
 * @property string $url_youtube
 * @property string $hours
 * @property string $categories
 * @property string $paymentOptions
 */
class Seller extends \yii\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            [['sellerId', 'userId', 'about', 'name', 'email', 'website', 'facebookSocialId', 'twitterSocialId', 'instagramSocialId', 'snapchatSocialId', 'linkedinSocialId', 'githubSocialId', 'url_youtube', 'hours', 'categories', 'paymentOptions'], 'required'],
            [['sellerId', 'userId', 'facebookSocialId', 'twitterSocialId', 'instagramSocialId', 'snapchatSocialId', 'linkedinSocialId', 'githubSocialId'], 'string', 'max' => 21],
            [['about'], 'string', 'max' => 420],
            [['name', 'email', 'website', 'url_youtube'], 'string', 'max' => 60],
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
            'website' => 'Website',
            'hours' => 'Hours',
            'categories' => 'Categories',
            'paymentOptions' => 'Payment Options',
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

    public function getReviewFacts()
    {
        return $this->hasMany(ReviewFact::className(), ['sellerId' => 'sellerId']);
    }

    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['reviewId' => 'reviewId'])
            ->via('reviewFacts');
    }
}
