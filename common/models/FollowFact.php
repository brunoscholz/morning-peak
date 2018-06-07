<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%followfact}}".
 *
 * @property string $followFactId
 * @property integer $actionReferenceId
 * @property string $userId
 * @property string $buyerId
 * @property string $sellerId
 * @property string $status
 */
class FollowFact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%followfact}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['followFactId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['followFactId', 'actionReferenceId', 'userId', 'status'], 'required'],
            [['actionReferenceId'], 'integer'],
            [['followFactId', 'userId', 'buyerId', 'sellerId'], 'string', 'max' => 21],
            [['status'], 'string', 'max' => 3],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['userId' => 'buyerId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['actionReferenceId'], 'exist', 'skipOnError' => true, 'targetClass' => ActionReference::className(), 'targetAttribute' => ['actionReferenceId' => 'actionReferenceId']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['followFactId', 'userId', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'followFactId' => 'Follow Fact ID',
            'actionReferenceId' => 'Action ID',
            'userId' => 'User ID',
            'buyerId' => 'Buyer ID',
            'sellerId' => 'Seller ID',
            'status' => 'Status',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'followFactId', $id])
            ->one();
    }

    public static function findByType($typ)
    {
        return static::find()
            ->where(['like', 'actionreference.actionType', $typ])
            ->one();
    }

    public function getUser()
    {
        return $this->hasOne(Buyer::className(), ['buyerId' => 'userId']);
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
