<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for transactions.
 *
 * @property string $transactionId
 * @property string $type
 * @property string $senderId
 * @property string $senderPublicKey
 * @property string $recipientId
 * @property string $amount
 * @property string $fee
 * @property string $timestamp
 * @property string $signature
 * @property string $tokenId
 * @property string $relationshipId
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class Transaction extends \yii\db\ActiveRecord
{
    protected $_updated_at;
    const TX_SALE = 0;
    const TX_TRADE = 200;

    // transaction's values (x2 when seller gives gifts)
    const VIEW_AMOUNT = 10;
    const FAVORITE_AMOUNT = 10;
    const FOLLOW_AMOUNT = 10;
    const COMMENT_AMOUNT = 25;
    const REVIEW_AMOUNT = 25;
    const SHARE_AMOUNT = 50;
    const CHECKIN_AMOUNT = 100;

    const GIFTED_MULTIPLIER = 2;

    public static $amountArray = [
        self::VIEW_AMOUNT,
        self::FAVORITE_AMOUNT,
        self::FOLLOW_AMOUNT,
        self::COMMENT_AMOUNT,
        self::REVIEW_AMOUNT,
        self::SHARE_AMOUNT,
        self::CHECKIN_AMOUNT,
    ];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transaction}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['transactionId'];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'timestamp',
                'value' => new Expression('NOW()'),
                //'value' => date('Y-m-d\Th:i:s'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transactionId', 'senderId', 'tokenId', 'amount', 'fee'], 'required'],
            [['type', 'amount', 'fee'], 'integer'],
            [['timestamp'], 'safe'],
            [['transactionId', 'senderId', 'recipientId', 'tokenId', 'relationshipId'], 'string', 'max' => 21],
            [['senderPublicKey'], 'string', 'max' => 64],
            [['signature'], 'string', 'max' => 128],
            [['relationshipId'], 'exist', 'skipOnError' => true, 'targetClass' => Relationship::className(), 'targetAttribute' => ['relationshipId' => 'relationshipId']],
            [['tokenId'], 'exist', 'skipOnError' => true, 'targetClass' => AssetToken::className(), 'targetAttribute' => ['tokenId' => 'tokenId']],
            [['senderId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['senderId' => 'userId']],
            [['recipientId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipientId' => 'userId']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['transactionId', 'amount', 'fee'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transactionId' => 'Transaction ID',
            'type' => 'Type',
            'senderId' => 'Sender ID',
            'senderPublicKey' => 'Sender Public Key',
            'recipientId' => 'Recipient ID',
            'amount' => 'Amount',
            'fee' => 'Fee',
            'timestamp' => 'Timestamp',
            'signature' => 'Signature',
            'tokenId' => 'Token ID',
            'relationshipId' => 'Relationship ID',
        ];
    }

    public function getUpdated_at() { return $this->_updated_at; }
    public function setUpdated_at($t) { $this->_updated_at = $t; }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'transactionId', $id])
            ->one();
    }

    /**
     * @method getToken()
     * Transaction relation with assetToken
     */
    public function getToken()
    {
        return $this->hasOne(AssetToken::className(), ['tokenId' => 'tokenId']);
    }

    /**
     * @method getRelationship()
     * Transaction relation with relationship
     */
    public function getRelationship()
    {
        return $this->hasOne(Relationship::className(), ['relationshipId' => 'relationshipId']);
    }

    /**
     * @method getSender()
     * The sender of the amount
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['userId' => 'senderId'])
            ->from(['sender' => User::tableName()]);
    }

    /**
     * @method getRecipient()
     * The recipient of the amount
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['userId' => 'recipientId'])
            ->from(['recipient' => User::tableName()]);
    }
}
