<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%asset_token}}".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $fund
 * @property integer $expirationPeriod
 */
class AssetToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%asset_token}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'description', 'expirationPeriod'], 'required'],
            [['description'], 'string'],
            [['fund', 'expirationPeriod'], 'integer'],
            [['id'], 'string', 'max' => 21],
            [['name'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'fund' => 'Fund',
            'expirationPeriod' => 'Expiration Period',
        ];
    }
}
