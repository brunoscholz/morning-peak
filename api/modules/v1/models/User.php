<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $userId
 * @property string $username
 * @property string $email
 * @property string $about
 * @property string $lastLogin
 * @property string $lastLoginIp
 * @property string $role
 * @property string $password
 * @property string $passwordStrategy
 * @property integer $requiresNewPassword
 * @property string $resetToken
 * @property string $salt
 * @property string $activation_key
 * @property string $validation_key
 * @property string $facebookSocialId
 * @property string $twitterSocialId
 * @property string $instagramSocialId
 * @property string $snapchatSocialId
 * @property string $linkedinSocialId
 * @property string $githubSocialId
 * @property string $avatar
 * @property string $paletteId
 * @property string $publicKey
 * @property integer $vendor
 * @property string $visibility
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'username', 'email', 'about', 'lastLogin', 'lastLoginIp', 'role', 'password', 'passwordStrategy', 'resetToken', 'salt', 'activation_key', 'validation_key', 'facebookSocialId', 'twitterSocialId', 'instagramSocialId', 'snapchatSocialId', 'linkedinSocialId', 'githubSocialId', 'avatar', 'paletteId', 'publicKey', 'vendor', 'visibility', 'status', 'createdAt', 'updatedAt'], 'required'],
            [['role'], 'string'],
            [['requiresNewPassword', 'vendor'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['userId', 'username', 'lastLogin', 'facebookSocialId', 'twitterSocialId', 'instagramSocialId', 'snapchatSocialId', 'linkedinSocialId', 'githubSocialId', 'paletteId'], 'string', 'max' => 21],
            [['email', 'avatar'], 'string', 'max' => 60],
            [['about', 'password', 'resetToken', 'salt', 'validation_key', 'publicKey'], 'string', 'max' => 255],
            [['lastLoginIp'], 'string', 'max' => 32],
            [['passwordStrategy'], 'string', 'max' => 50],
            [['activation_key'], 'string', 'max' => 128],
            [['visibility', 'status'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'username' => 'Username',
            'email' => 'Email',
            'about' => 'About',
            'lastLogin' => 'Last Login',
            'lastLoginIp' => 'Last Login Ip',
            'role' => 'Role',
            'password' => 'Password',
            'passwordStrategy' => 'Password Strategy',
            'requiresNewPassword' => 'Requires New Password',
            'resetToken' => 'Reset Token',
            'salt' => 'Salt',
            'activation_key' => 'Activation Key',
            'validation_key' => 'Validation Key',
            'facebookSocialId' => 'Facebook Social ID',
            'twitterSocialId' => 'Twitter Social ID',
            'instagramSocialId' => 'Instagram Social ID',
            'snapchatSocialId' => 'Snapchat Social ID',
            'linkedinSocialId' => 'Linkedin Social ID',
            'githubSocialId' => 'Github Social ID',
            'avatar' => 'Avatar',
            'paletteId' => 'Palette ID',
            'publicKey' => 'Public Key',
            'vendor' => 'Vendor',
            'visibility' => 'Visibility',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
