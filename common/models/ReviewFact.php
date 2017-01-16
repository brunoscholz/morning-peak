<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

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
    protected $_updated_at;
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'value' => new Expression('NOW()'),
                //'value' => date('Y-m-d\Th:i:s'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reviewFactId', 'actionReferenceId', 'reviewId', 'date', 'rating', 'status'], 'required'],
            [['actionReferenceId'], 'integer'],
            [['rating'], 'number'],
            [['reviewFactId', 'date'], 'safe'],
            [['reviewFactId', 'offerId', 'sellerId', 'buyerId', 'reviewId'], 'string', 'max' => 21],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
            [['reviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['reviewId' => 'reviewId']],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['actionReferenceId'], 'exist', 'skipOnError' => true, 'targetClass' => ActionReference::className(), 'targetAttribute' => ['actionReferenceId' => 'actionReferenceId']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['reviewFactId', 'actionReferenceId', 'offerId', 'buyerId', 'sellerId', 'rating', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reviewFactId' => 'Review Fact ID',
            'actionReferenceId' => 'Action ID',
            'offerId' => 'Offer ID',
            'sellerId' => 'Seller ID',
            'reviewId' => 'Review ID',
            'date' => 'Date',
            'rating' => 'Rating',
            'status' => 'Status',
        ];
    }

    public function getUpdated_at() { return $this->_updated_at; }
    public function setUpdated_at($t) { $this->_updated_at = $t; }

    public function getCommentFacts() {}

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

    public function getActionreference()
    {
        return $this->hasOne(ActionReference::className(), ['actionReferenceId' => 'actionReferenceId']);
    }
}
