<?php

namespace api\modules\v1\models;

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
    const TX_SALE = 0;
    const TX_TRADE = 200;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transactionId', 'senderId', 'amount', 'fee', 'timestamp'], 'required'],
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
