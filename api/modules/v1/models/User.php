<?php

namespace api\modules\v1\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%tbl_user}}".
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
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
 
class User extends \yii\db\ActiveRecord
{
    const ROLE_USER = 10;
    const ROLE_MODERATOR = 20;
    const ROLE_ADMIN = 30;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    // explicitly list every field, best used when you want to make sure the changes
    // in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password'], $fields['passwordStrategy'], $fields['resetToken'], $fields['salt'], $fields['activation_key'], $fields['validation_key']);
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'about', 'password', 'vendor', 'visibility'], 'required'],
            [['role'], 'string'],
            [['vendor'], 'integer'],
            [['lastLogin', 'createdAt', 'updatedAt'], 'safe'],
            [['userId', 'username', 'facebookSocialId', 'twitterSocialId', 'instagramSocialId', 'snapchatSocialId', 'linkedinSocialId', 'githubSocialId', 'paletteId'], 'string', 'max' => 21],
            [['email', 'avatar'], 'string', 'max' => 60],
            [['about', 'password', 'resetToken', 'salt', 'validation_key', 'publicKey'], 'string', 'max' => 255],
            [['lastLoginIp'], 'string', 'max' => 32],
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
            'userId' => 'UserID',
            'username' => 'Nome de Usuário',
            'email' => 'Email',
            'about' => 'Sobre',
            'lastLogin' => 'Last Login',
            'lastLoginIp' => 'Last Login Ip',
            'role' => 'Role',
            'password' => 'Senha',
            'passwordStrategy' => 'Password Strategy',
            'requiresNewPassword' => 'Requires New Password',
            'resetToken' => 'Reset Token',
            'salt' => 'Salt',
            'activation_key' => 'Chave de Ativação',
            'validation_key' => 'Chave de Validação',
            'facebookSocialId' => 'Facebook Social ID',
            'twitterSocialId' => 'Twitter Social ID',
            'instagramSocialId' => 'Instagram Social ID',
            'snapchatSocialId' => 'Snapchat Social ID',
            'linkedinSocialId' => 'Linkedin Social ID',
            'githubSocialId' => 'Github Social ID',
            'avatar' => 'Avatar',
            'paletteId' => 'ID Paleta',
            'publicKey' => 'Public Key',
            'vendor' => 'Vendor',
            'visibility' => 'Visibility',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'userId', $id])
            ->one();
    }

    public static function findByUsername($username)
    {
        return static::find()
            ->where(['like binary', 'username', $username])
            ->orWhere(['like binary', 'email', $username])
            ->one();
    }

    public function validatePassword($password)
    {
        $hashedPass = User::hashPassword($password, $this->salt);
        return $hashedPass === $this->password;
    }

    public static function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }
}
