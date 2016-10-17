<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%paymentlookup}}".
 *
 * @property string $paymentId
 * @property string $name
 * @property string $type
 * @property string $icon
 */
class PaymentLookup extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    //public $imageFile;

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
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['paymentId'], 'string', 'max' => 21],
            [['name'], 'string', 'max' => 30],
            [['type'], 'string', 'max' => 3],
            /*[['imageFile'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],*/
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
