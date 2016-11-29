<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%referencetransaction}}".
 *
 * @property string $referenceTransactionId
 * @property string $relationshipId
 * @property double $quantity
 * @property double $cost
 * @property double $price
 */
class ReferenceTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%referencetransaction}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['referenceTransactionId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['referenceTransactionId', 'relationshipId', 'quantity', 'cost', 'price'], 'required'],
            [['quantity', 'cost', 'price'], 'number'],
            [['referenceTransactionId', 'relationshipId'], 'string', 'max' => 21],
            [['relationshipId'], 'exist', 'skipOnError' => true, 'targetClass' => Relationship::className(), 'targetAttribute' => ['relationshipId' => 'relationshipId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'referenceTransactionId' => 'Reference Transaction ID',
            'relationshipId' => 'Relationship ID',
            'quantity' => 'Quantity',
            'cost' => 'Cost',
            'price' => 'Price',
        ];
    }
}
