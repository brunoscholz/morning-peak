<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%transactions}}".
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
 * @property string $token
 * @property integer $relationshipId
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
        return '{{%transactions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transactionId', 'senderId', 'amount', 'fee', 'timestamp'], 'required'],
            [['type', 'amount', 'fee'], 'integer'],
            [['transactionId', 'senderId', 'recipientId', 'tokenId', 'relationshipId'], 'string', 'max' => 21],
            [['senderPublicKey'], 'string', 'max' => 64],
            [['signature'], 'string', 'max' => 128],
            [['timestamp'], 'safe'],
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
            'tokenId' => 'Token',
            'relationshipId' => 'Relationship ID',
        ];
    }

    public function getToken()
    {
        return $this->hasOne(AssetToken::className(), ['tokenId' => 'tokenId']);
    }

    public function getSender()
    {
        return $this->hasOne(User::className(), ['senderId' => 'userId'])
            ->from(['sender' => User::tableName()]);
    }

    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['recipientId' => 'userId'])
            ->from(['recipient' => User::tableName()]);
    }
}
