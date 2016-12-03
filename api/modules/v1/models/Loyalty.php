<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%loyalty}}".
 *
 * @property string $loyaltyId
 * @property string $userId
 * @property string $actionId
 * @property string $ruleId
 * @property integer $points
 * @property string $transactionId
 * @property string $status
 */
class Loyalty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loyalty}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['loyaltyId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loyaltyId', 'userId', 'actionId', 'ruleId', 'points', 'transactionId', 'status'], 'required'],
            [['actionId', 'points'], 'integer'],
            [['loyaltyId', 'userId', 'ruleId', 'transactionId'], 'string', 'max' => 21],
            [['status'], 'string', 'max' => 3],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
            [['transactionId'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::className(), 'targetAttribute' => ['transactionId' => 'transactionId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loyaltyId' => 'Loyalty ID',
            'userId' => 'User ID',
            'actionId' => 'Action ID',
            'ruleId' => 'Rule ID',
            'points' => 'Points',
            'transactionId' => 'Transaction ID',
            'status' => 'Status',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
    }

    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['transactionId' => 'transactionId']);
    }

    public function getToken()
    {
        return $this->hasOne(AssetToken::className(), ['tokenId' => 'tokenId'])
            ->via('transaction');
    }
}
