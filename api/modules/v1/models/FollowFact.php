<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%followfact}}".
 *
 * @property string $followFactId
 * @property integer $actionId
 * @property string $userId
 * @property string $buyerId
 * @property string $sellerId
 */
class FollowFact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%followfact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['followFactId', 'actionId', 'userId'], 'required'],
            [['actionId'], 'integer'],
            [['followFactId', 'userId', 'buyerId', 'sellerId'], 'string', 'max' => 21],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['userId' => 'buyerId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'followFactId' => 'Follow Fact ID',
            'actionId' => 'Action ID',
            'userId' => 'User ID',
            'buyerId' => 'Buyer ID',
            'sellerId' => 'Seller ID',
        ];
    }
}