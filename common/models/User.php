<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * User Model
 * This is the model class for table "{{%user}}".
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class User extends \yii\db\ActiveRecord
{
    const ROLE_USER = 'regular';
    const ROLE_SALES = 'salesman';
    const ROLE_ADMIN = 'administrator';

    const USER_EXISTS = '401';

    const STATUS_ACTIVE = 'ACT';
    const STATUS_NOT_VERIFIED = 'PEN';
    const STATUS_BANNED = 'BAN';
    const STATUS_REMOVED = 'REM';

    public static $statusArray = [
        self::STATUS_ACTIVE,
        self::STATUS_NOT_VERIFIED,
        self::STATUS_BANNED,
        self::STATUS_REMOVED,
    ];

    private $_preferredProfile = ['id' => '', 'type' => 'buyer'];

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
    public static function primaryKey()
    {
        return ['userId'];
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
            [['email'], 'required'],
            [['role'], 'string'],
            [['vendor'], 'integer'],
            [['lastLogin', 'createdAt', 'updatedAt'], 'safe'],
            [['userId', 'username', 'paletteId'], 'string', 'max' => 21],
            [['email', 'avatar'], 'string', 'max' => 60],
            [['about', 'password', 'resetToken', 'salt', 'validation_key', 'publicKey'], 'string', 'max' => 255],
            [['lastLoginIp'], 'string', 'max' => 32],
            [['activation_key'], 'string', 'max' => 128],
            [['visibility', 'status'], 'string', 'max' => 3],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
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

    /*
    public function getPreferredProfile()
    {
        if(empty($this->_preferredProfile['id']) || $this->_preferredProfile['id'] == '')
        {
            $this->setPreferredProfile($this->buyerId, 'buyer');
        }

        return $this->_preferredProfile;
    }

    public function setPreferredProfile($id, $type)
    {
        $this->_preferredProfile['id'] = $id;
        $this->_preferredProfile['type'] = $type;
    }
    */

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

    public function verifyKeys($activationKey)
    {
        return $this->validation_key === md5($activationKey . $this->email . $this->userId);
    }

    public function getBuyer()
    {
        return $this->hasOne(Buyer::className(), ['buyerId' => 'buyerId']);
    }

    public function getSellers()
    {
        return $this->hasMany(Seller::className(), ['userId' => 'userId']);
    }

    public function getSocial()
    {
        return $this->hasMany(SocialAccount::className(), ['userId' => 'userId']);
    }

    public function getTransactions()
    {
        //return $this->hasMany(Transaction::className(), ['userId' => 'senderId']);
    }
}
