<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%loyalty}}".
 *
 * @property string $loyaltyId
 * @property string $buyerId
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
    public function rules()
    {
        return [
            [['loyaltyId', 'buyerId', 'actionId', 'ruleId', 'points', 'transactionId', 'status'], 'required'],
            [['points'], 'integer'],
            [['loyaltyId', 'buyerId', 'actionId', 'ruleId', 'transactionId'], 'string', 'max' => 21],
            [['status'], 'string', 'max' => 3],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['transactionId'], 'exist', 'skipOnError' => true, 'targetClass' => Transactions::className(), 'targetAttribute' => ['transactionId' => 'transactionId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loyaltyId' => 'Loyalty ID',
            'buyerId' => 'Buyer ID',
            'actionId' => 'Action ID',
            'ruleId' => 'Rule ID',
            'points' => 'Points',
            'transactionId' => 'Transaction ID',
            'status' => 'Status',
        ];
    }
}
