<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%actionrelationship}}".
 *
 * @property string $actionRelationshipId
 * @property integer $actionReferenceId
 * @property string $followFactId
 * @property string $favoriteFactId
 * @property string $commentFactId
 * @property string $reviewFactId
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
            [['actionRelationshipId', 'favoriteFactId', 'followFactId', 'commentFactId', 'reviewFactId', 'loyaltyId'], 'string', 'max' => 21],
            [['actionReferenceId'], 'exist', 'skipOnError' => true, 'targetClass' => Actionreference::className(), 'targetAttribute' => ['actionReferenceId' => 'actionReferenceId']],
            [['loyaltyId'], 'exist', 'skipOnError' => true, 'targetClass' => Loyalty::className(), 'targetAttribute' => ['loyaltyId' => 'loyaltyId']],
            [['followFactId'], 'exist', 'skipOnError' => true, 'targetClass' => Followfact::className(), 'targetAttribute' => ['followFactId' => 'followFactId']],
            [['commentFactId'], 'exist', 'skipOnError' => true, 'targetClass' => Commentfact::className(), 'targetAttribute' => ['commentFactId' => 'commentFactId']],
            [['reviewFactId'], 'exist', 'skipOnError' => true, 'targetClass' => Reviewfact::className(), 'targetAttribute' => ['reviewFactId' => 'reviewFactId']],
            [['favoriteFactId'], 'exist', 'skipOnError' => true, 'targetClass' => Favoritefact::className(), 'targetAttribute' => ['favoriteFactId' => 'favoriteFactId']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['actionRelationshipId'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'actionRelationshipId' => 'Action Relationship ID',
            'actionReferenceId' => 'Action Reference ID',
            'followFactId' => 'Follow ID',
            'commentFactId' => 'Comment ID',
            'reviewFactId' => 'Review ID',
            'favoriteFactId' => 'Favorite ID',
            'loyaltyId' => 'Loyalty ID',
        ];
    }

    public function getLoyalty()
    {
        return $this->hasOne(Loyalty::className(), ['loyaltyId' => 'loyaltyId'])
            ->with(['buyer', 'transaction']);
    }

    public function getReviewFact()
    {
        return $this->hasOne(Reviewfact::className(), ['reviewFactId' => 'reviewFactId']);
    }

    public function getFollowFact()
    {
        return $this->hasOne(Followfact::className(), ['followFactId' => 'followFactId']);
    }

    public function getCommentFact()
    {
        return $this->hasOne(Commentfact::className(), ['commentFactId' => 'commentFactId']);
    }

    public function getFavoriteFact()
    {
        return $this->hasOne(Favoritefact::className(), ['favoriteFactId' => 'favoriteFactId']);
    }
}
