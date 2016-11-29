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
 * @property integer $expires
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
    public static function primaryKey()
    {
        return ['tokenId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tokenId', 'name', 'description', 'expires'], 'required'],
            [['description'], 'string', 'max' => 40 ],
            [['fund', 'expires'], 'integer'],
            [['tokenId'], 'string', 'max' => 21],
            [['name'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tokenId' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'fund' => 'Fund',
            'expires' => 'Expiration Period',
        ];
    }

    public static function findByCode($id)
    {
        return static::find()
            ->where(['like binary', 'name', $id])
            ->one();
    }
}
