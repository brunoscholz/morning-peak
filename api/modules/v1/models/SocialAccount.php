<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%social_account}}".
 *
 * @property string $socialId
 * @property string $buyerId
 * @property string $sellerId
 * @property string $externalId
 * @property string $name
 * @property string $status
 */
class SocialAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%social_account}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['socialId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['socialId', 'externalId', 'name', 'status'], 'required'],
            [['socialId', 'buyerId', 'sellerId'], 'string', 'max' => 21],
            [['externalId'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 3],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'socialId' => 'Social ID',
            'buyerId' => 'Buyer ID',
            'sellerId' => 'Seller ID',
            'externalId' => 'External ID',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }
}
