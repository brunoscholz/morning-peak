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
 * @property string $transactionId
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
            [['actionRelationshipId', 'actionReferenceId', 'transactionId'], 'required'],
            [['actionReferenceId'], 'integer'],
            [['actionRelationshipId', 'favoriteFactId', 'followFactId', 'commentFactId', 'reviewFactId', 'transactionId'], 'string', 'max' => 21],
            [['actionReferenceId'], 'exist', 'skipOnError' => true, 'targetClass' => Actionreference::className(), 'targetAttribute' => ['actionReferenceId' => 'actionReferenceId']],
            [['transactionId'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::className(), 'targetAttribute' => ['transactionId' => 'transactionId']],
            [['followFactId'], 'exist', 'skipOnError' => true, 'targetClass' => FollowFact::className(), 'targetAttribute' => ['followFactId' => 'followFactId']],
            [['commentFactId'], 'exist', 'skipOnError' => true, 'targetClass' => CommentFact::className(), 'targetAttribute' => ['commentFactId' => 'commentFactId']],
            [['reviewFactId'], 'exist', 'skipOnError' => true, 'targetClass' => ReviewFact::className(), 'targetAttribute' => ['reviewFactId' => 'reviewFactId']],
            [['favoriteFactId'], 'exist', 'skipOnError' => true, 'targetClass' => FavoriteFact::className(), 'targetAttribute' => ['favoriteFactId' => 'favoriteFactId']],
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
            'favoriteFactId' => 'Favorite ID',
            'commentFactId' => 'Comment ID',
            'reviewFactId' => 'Review ID',
            'transactionId' => 'Transaction ID',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'actionRelationshipId', $id])
            ->one();
    }

    public static function findByModelId($model, $id, $typ = '')
    {
        $query = static::find();

        $query->where(['like binary', $model.'Id', $id]);

        if (!empty($typ)) {
            $query->andFilterWhere(['=', 'actionReferenceId', $typ]);
        }

        //var_dump($query->createCommand()->rawsql);

        return $query->one();
    }

    public static function findByType($typ)
    {
        return static::find()
            ->where(['like', 'actionreference.actionType', $typ])
            ->one();
    }

    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['transactionId' => 'transactionId']);
    }

    public function getReviewFact()
    {
        return $this->hasOne(ReviewFact::className(), ['reviewFactId' => 'reviewFactId']);
    }

    public function getFollowFact()
    {
        return $this->hasOne(FollowFact::className(), ['followFactId' => 'followFactId']);
    }

    public function getCommentFact()
    {
        return $this->hasOne(CommentFact::className(), ['commentFactId' => 'commentFactId']);
    }

    public function getFavoriteFact()
    {
        return $this->hasOne(FavoriteFact::className(), ['favoriteFactId' => 'favoriteFactId']);
    }
}
