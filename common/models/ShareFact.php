<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sharefact}}".
 *
 * @property string $shareFactId
 * @property integer $actionReferenceId
 * @property string $buyerId
 * @property string $offerId
 * @property string $status
 */
class ShareFact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sharefact}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['shareFactId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shareFactId', 'actionReferenceId', 'buyerId', 'offerId', 'status'], 'required'],
            [['actionReferenceId'], 'integer'],
            [['shareFactId', 'buyerId', 'offerId'], 'string', 'max' => 21],
            [['status'], 'string', 'max' => 3],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['actionReferenceId'], 'exist', 'skipOnError' => true, 'targetClass' => ActionReference::className(), 'targetAttribute' => ['actionReferenceId' => 'actionReferenceId']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['shareFactId', 'actionReferenceId', 'buyerId', 'offerId', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shareFactId' => 'Favorite Fact ID',
            'actionReferenceId' => 'Action ID',
            'buyerId' => 'Buyer ID',
            'offerId' => 'Offer ID',
            'status' => 'Status',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'shareFactId', $id])
            ->one();
    }

    public static function findByType($typ)
    {
        return static::find()
            ->where(['like', 'actionreference.actionType', $typ])
            ->one();
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
