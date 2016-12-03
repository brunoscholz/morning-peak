<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%reviewfact}}".
 *
 * @property string $reviewFactId
 * @property integer $actionId
 * @property string $offerId
 * @property string $sellerId
 * @property string $reviewId
 * @property string $date
 * @property double $rating
 */
class ReviewFact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reviewfact}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['reviewFactId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reviewFactId', 'actionId', 'reviewId', 'date', 'rating'], 'required'],
            [['actionId'], 'integer'],
            [['rating'], 'number'],
            [['reviewFactId', 'date'], 'safe'],
            [['reviewFactId', 'offerId', 'sellerId', 'reviewId'], 'string', 'max' => 21],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
            [['reviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['reviewId' => 'reviewId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reviewFactId' => 'Review Fact ID',
            'actionId' => 'Action ID',
            'offerId' => 'Offer ID',
            'sellerId' => 'Seller ID',
            'reviewId' => 'Review ID',
            'date' => 'Date',
            'rating' => 'Rating',
        ];
    }

    public function getCommentFacts()
    {
    }

    public function getComments()
    {
        return $this->hasMany(CommentFact::className(), ['reviewFactId' => 'reviewFactId']);
        /*return $this->hasMany(Comment::className(), ['commentId' => 'commentId'])
            ->via('commentFacts');*/
    }

    public function getReview()
    {
        return $this->hasOne(Review::className(), ['reviewId' => 'reviewId']);
    }

    public function getBuyer()
    {
        return $this->hasOne(Buyer::className(), ['buyerId' => 'buyerId']);
    }

    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['sellerId' => 'sellerId']);
    }

    public function getOffer()
    {
        return $this->hasOne(Offer::className(), ['offerId' => 'offerId']);
    }
}
