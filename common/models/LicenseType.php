<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%license_type}}".
 *
 * @property string $licenseTypeId
 * @property string $title
 * @property string $description
 * @property double $value
 * @property string $expirationTime
 * @property string $status
 *
 * @property License[] $licenses
 */
class LicenseType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%license_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['licenseTypeId', 'title', 'description', 'value', 'expirationTime', 'status'], 'required'],
            [['value'], 'number'],
            [['licenseTypeId'], 'string', 'max' => 21],
            [['title', 'description'], 'string', 'max' => 64],
            [['expirationTime'], 'string', 'max' => 11],
            [['status'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'licenseTypeId' => 'License Type ID',
            'title' => 'Title',
            'description' => 'Description',
            'value' => 'Value',
            'expirationTime' => 'Expiration Time',
            'status' => 'Status',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'licenseTypeId', $id])
            ->one();
    }

    // AT1, AT2, AT3
    public static function findByType($id)
    {
        return static::find()
            ->where(['like binary', 'status', $id])
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicenses()
    {
        return $this->hasMany(License::className(), ['licenseTypeId' => 'licenseTypeId']);
    }
}
