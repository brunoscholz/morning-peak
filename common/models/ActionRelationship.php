<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%actionrelationship}}".
 *
 * @property string $actionRelationshipId
 * @property integer $actionReferenceId
 * @property string $followId
 * @property string $commentId
 * @property string $reviewId
 * @property string $loyaltyId
 */
class ActionRelationship extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%actionrelationship}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['actionRelationshipId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['actionRelationshipId', 'actionReferenceId', 'loyaltyId'], 'required'],
            [['actionReferenceId'], 'integer'],
            [['actionRelationshipId', 'followId', 'commentId', 'reviewId', 'loyaltyId'], 'string', 'max' => 21],
            [['loyaltyId'], 'exist', 'skipOnError' => true, 'targetClass' => Loyalty::className(), 'targetAttribute' => ['loyaltyId' => 'loyaltyId']],
            [['actionReferenceId'], 'exist', 'skipOnError' => true, 'targetClass' => Actionreference::className(), 'targetAttribute' => ['actionReferenceId' => 'actionReferenceId']],
            [['followId'], 'exist', 'skipOnError' => true, 'targetClass' => Followfact::className(), 'targetAttribute' => ['followId' => 'followFactId']],
            [['commentId'], 'exist', 'skipOnError' => true, 'targetClass' => Commentfact::className(), 'targetAttribute' => ['commentId' => 'commentFactId']],
            [['reviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Reviewfact::className(), 'targetAttribute' => ['reviewId' => 'reviewFactId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'actionRelationshipId' => 'Action Relationship ID',
            'actionReferenceId' => 'Action Reference ID',
            'followId' => 'Follow ID',
            'commentId' => 'Comment ID',
            'reviewId' => 'Review ID',
            'loyaltyId' => 'Loyalty ID',
        ];
    }
}
