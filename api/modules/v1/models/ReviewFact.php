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
 * @property string $grades
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
    public function rules()
    {
        return [
            [['reviewFactId', 'actionId', 'reviewId', 'grades', 'rating'], 'required'],
            [['actionId'], 'integer'],
            [['rating'], 'number'],
            [['reviewFactId', 'offerId', 'sellerId', 'reviewId'], 'string', 'max' => 21],
            [['grades'], 'string', 'max' => 255],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
            [['offerId'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offerId' => 'offerId']],
            [['reviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['reviewId' => 'reviewId']],
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
            'grades' => 'Grades',
            'rating' => 'Rating',
        ];
    }
}
