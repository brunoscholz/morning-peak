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
    const STATUS_REMOVED = 'REM';
    const STATUS_BANNED = 'BAN';
    const STATUS_NOT_VERIFIED = 'PEN';

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

    // explicitly list every field, best used when you want to make sure the changes
    // in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password'], $fields['resetKey'], $fields['resetToken'], $fields['salt'], $fields['activation_key'], $fields['validation_key']);
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'buyerId'], 'required'],
            [['role'], 'string'],
            [['vendor'], 'integer'],
            [['lastLogin', 'createdAt', 'updatedAt'], 'safe'],
            [['userId', 'username', 'paletteId'], 'string', 'max' => 21],
            [['email', 'avatar'], 'string', 'max' => 60],
            [['about', 'password', 'salt', 'publicKey'], 'string', 'max' => 255],
            [['lastLoginIp'], 'string', 'max' => 32],
            [['activation_key', 'resetKey'], 'string', 'max' => 12],
            [['validation_key', 'resetToken'], 'string', 'max' => 64],
            [['visibility', 'status'], 'string', 'max' => 3],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['userId', 'username', 'role', 'email', 'vendor', 'status'];
        return $scenarios;
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
            'role' => 'Tipo',
            'password' => 'Senha',
            'requiresNewPassword' => 'Requires New Password',
            'resetKey' => 'Reset Key',
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

    public static function findByBuyerId($id)
    {
        return static::find()
            ->where(['like binary', 'buyerId', $id])
            ->one();
    }

    public function validatePassword($password)
    {
        $hashedPass = self::hashPassword($password, $this->salt);
        return $hashedPass === $this->password;
    }

    public static function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }

    public static function findByPasswordResetToken($token)
    {
        $selector = substr($token, 0, 12);
        $authenticator = substr($token, 12);

        $model = static::find()
            ->where(['like binary', 'resetKey', $selector])
            ->one();
        
        if($model && $model->verifyResetKeys($authenticator))
            return $model;

        return null;
    }

    public function setPassword($password)
    {
        $this->salt = \backend\components\Utils::generateSalt();
        $this->password = self::hashPassword($password, $this->salt);
    }

    public function removePasswordResetToken()
    {
        $this->resetToken = '';
        $this->resetKey = '';
        $this->requiresNewPassword = 1;
    }

    public function verifyKeys($activationKey)
    {
        return $this->validation_key === hash('sha256', base64_decode($activationKey));
    }

    public function verifyResetKeys($resetKey)
    {
        return $this->resetToken === hash('sha256', base64_decode($resetKey));
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
