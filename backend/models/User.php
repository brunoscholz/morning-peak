<?php

namespace backend\models;

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
 *
 * @property VitUsermeta[] $vitUsermetas
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ROLE_USER = 'regular';
    const ROLE_SALES = 'salesman';
    const ROLE_ADMIN = 'administrator';

    const STATUS_ACTIVE = 'ACT';
    const STATUS_NOT_VERIFIED = 'PEN';
    const STATUS_BANNED = 'BAN';

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
            [['email', 'vendor'], 'required'],
            [['role'], 'string'],
            [['vendor'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['userId', 'username', 'lastLogin', 'facebookSocialId', 'twitterSocialId', 'instagramSocialId', 'snapchatSocialId', 'linkedinSocialId', 'githubSocialId', 'paletteId'], 'string', 'max' => 21],
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

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'userId', $id])
            ->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
    public function getId()
    {
        return $this->userId;
    }
    public function getAuthKey()
    {
        return "";
    }
    public function validateAuthKey($authKey)
    {
        return "";
    }

    public static function findByUsername($username)
    {
        return static::find()
            ->where(['username' => $username])
            ->orWhere(['email' => $username])
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVitUsermetas()
    {
        return $this->hasMany(VitUsermeta::className(), ['userId' => 'userId']);
    }

    public static function generateId()
    {
        //md5(uniqid($name, true));
        return User::getToken(21);
    }

    public static function generateSalt()
    {
        return User::getToken(64);
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

    public static function generateActivationKey()
    {
        return User::getToken(8);
    }

    public static function generateValidationKey($key, $email, $id)
    {
        return  md5($key . $email . $id);
    }

    public function verifyKeys($activationKey)
    {
        return $this->validation_key === md5($activationKey . $this->email . $this->userId);
    }

    static function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public static function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[User::crypto_rand_secure(0, $max)];
        }

        return $token;
    }
}
