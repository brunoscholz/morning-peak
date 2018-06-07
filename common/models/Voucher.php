<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%voucher}}".
 *
 * @property string $voucherId
 * @property string $code
 * @property integer $discount
 * @property string $expire
 * @property integer $count
 */
class Voucher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%voucher}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voucherId', 'code'], 'required'],
            [['discount', 'count'], 'integer'],
            [['expire'], 'safe'],
            [['voucherId'], 'string', 'max' => 21],
            [['code'], 'string', 'max' => 12],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'voucherId' => 'Voucher ID',
            'code' => 'Code',
            'discount' => 'Discount',
            'expire' => 'Expire',
            'count' => 'Count',
        ];
    }
}
