<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%paymentlookup}}".
 *
 * @property string $paymentId
 * @property string $name
 * @property string $type
 * @property resource $icon
 */
class PaymentLookup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%paymentlookup}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['paymentId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paymentId', 'name', 'type', 'icon'], 'required'],
            [['icon'], 'string'],
            [['paymentId'], 'string', 'max' => 21],
            [['name'], 'string', 'max' => 30],
            [['type'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'paymentId' => 'Payment ID',
            'name' => 'Name',
            'type' => 'Type',
            'icon' => 'Icon',
        ];
    }
}
