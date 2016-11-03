<?php

namespace api\modules\v1\models;

use Yii;

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
            'about' => 'About',
            'name' => 'Name',
            'email' => 'Email',
            'website' => 'Website',
            'facebookSocialId' => 'Facebook Social ID',
            'twitterSocialId' => 'Twitter Social ID',
            'instagramSocialId' => 'Instagram Social ID',
            'snapchatSocialId' => 'Snapchat Social ID',
            'linkedinSocialId' => 'Linkedin Social ID',
            'githubSocialId' => 'Github Social ID',
            'url_youtube' => 'Url Youtube',
            'hours' => 'Hours',
            'categories' => 'Categories',
            'paymentOptions' => 'Payment Options',
        ];
    }
}
