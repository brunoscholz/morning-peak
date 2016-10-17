<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%buyer}}".
 *
 * @property string $buyerId
 * @property string $userId
 * @property string $about
 * @property string $birthday
 * @property string $firstname
 * @property string $lastname
 * @property string $gender
 * @property string $email
 * @property string $title
 * @property string $website
 * @property string $url_facebook
 * @property string $url_googleplus
 * @property string $url_flickr
 * @property string $url_linkedin
 * @property string $url_twitter
 * @property string $url_vimeo
 * @property string $url_youtube
 * @property string $url_instagram
 *
 * @property User $user
 * @property Loyalty[] $loyalties
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
    public function rules()
    {
        return [
            [['buyerId', 'userId', 'about', 'birthday', 'firstname', 'lastname', 'gender', 'email', 'title', 'website', 'url_facebook', 'url_googleplus', 'url_flickr', 'url_linkedin', 'url_twitter', 'url_vimeo', 'url_youtube', 'url_instagram'], 'required'],
            [['buyerId', 'userId', 'birthday'], 'string', 'max' => 21],
            [['about'], 'string', 'max' => 420],
            [['firstname', 'lastname'], 'string', 'max' => 40],
            [['gender'], 'string', 'max' => 3],
            [['email', 'website', 'url_facebook', 'url_googleplus', 'url_flickr', 'url_linkedin', 'url_twitter', 'url_vimeo', 'url_youtube', 'url_instagram'], 'string', 'max' => 60],
            [['title'], 'string', 'max' => 10],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
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
            'about' => 'About',
            'birthday' => 'Birthday',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'gender' => 'Gender',
            'email' => 'Email',
            'title' => 'Title',
            'website' => 'Website',
            'url_facebook' => 'Url Facebook',
            'url_googleplus' => 'Url Googleplus',
            'url_flickr' => 'Url Flickr',
            'url_linkedin' => 'Url Linkedin',
            'url_twitter' => 'Url Twitter',
            'url_vimeo' => 'Url Vimeo',
            'url_youtube' => 'Url Youtube',
            'url_instagram' => 'Url Instagram',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoyalties()
    {
        return $this->hasMany(Loyalty::className(), ['buyerId' => 'buyerId']);
    }
}
