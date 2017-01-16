<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%license}}".
 *
 * @property string $licenseId
 * @property string $sellerId
 * @property string $licenseTypeId
 * @property string $expiration
 * @property string $status
 *
 * @property LicenseType $licenseType
 * @property Seller $seller
 */
class License extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%license}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['licenseId', 'sellerId', 'licenseTypeId', 'expiration', 'status'], 'required'],
            [['expiration'], 'safe'],
            [['licenseId', 'sellerId', 'licenseTypeId'], 'string', 'max' => 21],
            [['status'], 'string', 'max' => 3],
            [['licenseTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => LicenseType::className(), 'targetAttribute' => ['licenseTypeId' => 'licenseTypeId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['licenseId', 'licenseTypeId', 'expiration', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'licenseId' => 'License ID',
            'sellerId' => 'Seller ID',
            'licenseTypeId' => 'License Type ID',
            'expiration' => 'Expiration',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicenseType()
    {
        return $this->hasOne(LicenseType::className(), ['licenseTypeId' => 'licenseTypeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['sellerId' => 'sellerId']);
    }
}
