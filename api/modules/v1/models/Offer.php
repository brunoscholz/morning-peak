<?php

namespace api\modules\v1\models;

use Yii;
use \backend\models\Picture;

/**
 * Offer Model
 * This is the model class for table "{{%offer}}".
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%offer}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['offerId'];
    }

    // explicitly list every field, best used when you want to make sure the changes
    // in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['itemId'], $fields['sellerId'], $fields['policyId'], $fields['shippingId']);
        return $fields;
        /*return [
            // field name is the same as the attribute name
            'id',
            // field name is "email", the corresponding attribute name is "email_address"
            'email' => 'email_address',
            // field name is "name", its value is defined by a PHP callback
            'name' => function ($model) {
                return $model->first_name . ' ' . $model->last_name;
            },
        ];*/
    }

    public function extraFields()
    {
        return [
            'item',
            'seller',
            'shipping',
            'policy',
            'reviews'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['offerId', 'itemId', 'sellerId', 'pricePerUnit', 'description', 'imageHashes'], 'required'],
            [['pricePerUnit', 'discountPerUnit'], 'number'],
            [['imageHashes', 'keywords'], 'string'],
            [['offerId', 'itemId', 'sellerId', 'policyId', 'shippingId'], 'string', 'max' => 21],
            [['description'], 'string', 'max' => 255],
            [['itemCondition', 'status'], 'string', 'max' => 3],
            [['itemId'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['itemId' => 'itemId']],
            [['policyId'], 'exist', 'skipOnError' => true, 'targetClass' => Policy::className(), 'targetAttribute' => ['policyId' => 'policyId']],
            [['shippingId'], 'exist', 'skipOnError' => true, 'targetClass' => Shipping::className(), 'targetAttribute' => ['shippingId' => 'shippingId']],
            [['sellerId'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['sellerId' => 'sellerId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'offerId' => 'Offer ID',
            'itemId' => 'Item ID',
            'sellerId' => 'Seller ID',
            'policyId' => 'Policy ID',
            'shippingId' => 'Shipping ID',
            'pricePerUnit' => 'Price Per Unit',
            'discountPerUnit' => 'Discount Per Unit',
            'description' => 'Description',
            'imageHashes' => 'Image Hashes',
            'keywords' => 'Keywords',
            'itemCondition' => 'Condition',
            'status' => 'Status',
        ];
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['itemId' => 'itemId'])
            ->with('category');
    }

    public function getPolicy()
    {
        return $this->hasOne(Policy::className(), ['policyId' => 'policyId']);
    }

    public function getShipping()
    {
        return $this->hasOne(Shipping::className(), ['shippingId' => 'shippingId']);
    }

    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['sellerId' => 'sellerId'])
            ->with(['user', 'reviews']);
    }

    public function getReviewFacts()
    {
        return $this->hasMany(ReviewFact::className(), ['offerId' => 'offerId']);
    }

    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['reviewId' => 'reviewId'])
            ->via('reviewFacts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['pictureId' => 'pictureId']);
    }
}
