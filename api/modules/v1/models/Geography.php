<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%geography}}".
 *
 * @property integer $geographyId
 * @property string $cityCode
 * @property string $cityName
 * @property string $stateCode
 * @property string $stateName
 * @property string $countryCode
 * @property string $countryName
 */
class Geography extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%geography}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['geographyId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityCode', 'cityName', 'stateCode', 'stateName', 'countryCode', 'countryName'], 'required'],
            [['cityCode', 'stateCode', 'countryCode'], 'string', 'max' => 3],
            [['cityName', 'stateName'], 'string', 'max' => 42],
            [['countryName'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'geographyId' => 'Geography ID',
            'cityCode' => 'City Code',
            'cityName' => 'City Name',
            'stateCode' => 'State Code',
            'stateName' => 'State Name',
            'countryCode' => 'Country Code',
            'countryName' => 'Country Name',
        ];
    }
}
