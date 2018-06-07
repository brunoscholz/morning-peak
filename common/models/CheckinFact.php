<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%checkinfact}}".
 *
 * @property string $checkinFactId
 * @property integer $actionReferenceId
 * @property string $buyerId
 * @property string $sellerId
 * @property string $status
 */
class CheckinFact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%checkinfact}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['checkinFactId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['checkinFactId', 'actionReferenceId', 'buyerId', 'sellerId', 'status'], 'required'],
            [['actionReferenceId'], 'integer'],
            [['checkinFactId', 'buyerId', 'sellerId'], 'string', 'max' => 21],
            [['status'], 'string', 'max' => 3],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['actionReferenceId'], 'exist', 'skipOnError' => true, 'targetClass' => ActionReference::className(), 'targetAttribute' => ['actionReferenceId' => 'actionReferenceId']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['checkinFactId', 'actionReferenceId', 'buyerId', 'sellerId', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'checkinFactId' => 'CheckIn Fact ID',
            'actionReferenceId' => 'Action ID',
            'buyerId' => 'Buyer ID',
            'sellerId' => 'Seller ID',
            'status' => 'Status',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'checkinFactId', $id])
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

    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['sellerId' => 'sellerId']);
    }

    public function getActionreference()
    {
        return $this->hasOne(ActionReference::className(), ['actionReferenceId' => 'actionReferenceId']);
    }
}
