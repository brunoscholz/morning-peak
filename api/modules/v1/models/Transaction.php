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
            [['transactionId', 'type', 'senderId', 'senderPublicKey', 'amount', 'fee', 'timestamp', 'signature', 'relationshipId'], 'required'],
            [['type', 'amount', 'fee', 'timestamp', 'relationshipId'], 'integer'],
            [['transactionId', 'senderId', 'recipientId', 'tokenId'], 'string', 'max' => 21],
            [['senderPublicKey'], 'string', 'max' => 64],
            [['signature'], 'string', 'max' => 128],
            [['tokenId'], 'exist', 'skipOnError' => true, 'targetClass' => AssetToken::className(), 'targetAttribute' => ['tokenId' => 'tokenId']],
            [['senderId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'senderId']],
            [['recipientId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'recipientId']],
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
        return $this->hasOne(User::className(), ['userId' => 'senderId'])->from(['sender' => User::tableName()]);
    }

    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['userId' => 'recipientId'])->from(['recipient' => User::tableName()]);
    }
}
