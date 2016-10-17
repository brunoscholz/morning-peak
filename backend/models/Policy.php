<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%policy}}".
 *
 * @property string $policyId
 * @property string $terms
 * @property string $returns
 *
 * @property Offer[] $offers
 */
class Policy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%policy}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['policyId', 'terms', 'returns'], 'required'],
            [['terms', 'returns'], 'string'],
            [['policyId'], 'string', 'max' => 21],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'policyId' => 'Policy ID',
            'terms' => 'Terms',
            'returns' => 'Returns',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffers()
    {
        return $this->hasMany(Offer::className(), ['policyId' => 'policyId']);
    }
}
