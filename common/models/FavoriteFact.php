<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%favoritefact}}".
 *
 * @property string $favoriteFactId
 * @property integer $actionReferenceId
 * @property string $buyerId
 * @property string $offerId
 * @property string $status
 */
class FavoriteFact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favoritefact}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['favoriteFactId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['favoriteFactId', 'actionReferenceId', 'buyerId', 'offerId', 'status'], 'required'],
            [['actionReferenceId'], 'integer'],
            [['favoriteFactId', 'buyerId', 'offerId'], 'string', 'max' => 21],
            [['status'], 'string', 'max' => 3],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['actionReferenceId'], 'exist', 'skipOnError' => true, 'targetClass' => ActionReference::className(), 'targetAttribute' => ['actionReferenceId' => 'actionReferenceId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'favoriteFactId' => 'Favorite Fact ID',
            'actionReferenceId' => 'Action ID',
            'buyerId' => 'Buyer ID',
            'offerId' => 'Offer ID',
            'status' => 'Status',
        ];
    }

    public function getBuyer()
    {
        return $this->hasOne(Buyer::className(), ['buyerId' => 'buyerId']);
    }

    public function getOffer()
    {
        return $this->hasOne(Offer::className(), ['offerId' => 'offerId']);
    }

    public function getActionreference()
    {
        return $this->hasOne(ActionReference::className(), ['actionReferenceId' => 'actionReferenceId']);
    }
}
