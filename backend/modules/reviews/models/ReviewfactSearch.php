<?php

namespace backend\modules\review\models;

use Yii;

/**
 * This is the model class for table "{{%reviewfact}}".
 *
 * @property string $reviewFactId
 * @property integer $actionReferenceId
 * @property string $offerId
 * @property string $buyerId
 * @property string $sellerId
 * @property string $reviewId
 * @property string $grades
 * @property double $rating
 */
class ReviewfactSearch extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['reviewFactId', 'actionReferenceId', 'reviewId', 'grades', 'rating'], 'required'],
            [['actionReferenceId'], 'integer'],
            [['rating'], 'number'],
            [['reviewFactId', 'offerId', 'buyerId', 'sellerId', 'reviewId'], 'string', 'max' => 21],
            [['grades'], 'string', 'max' => 255],
            [['buyerId'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyerId' => 'buyerId']],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
            [['reviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['reviewId' => 'reviewId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
        ];
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
            'buyerId' => 'Buyer ID',
            'sellerId' => 'Seller ID',
            'reviewId' => 'Review ID',
            'grades' => 'Grades',
            'rating' => 'Rating',
        ];
    }
}
