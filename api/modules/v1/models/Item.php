<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property string $itemId
 * @property string $sku
 * @property string $categoryId
 * @property string $description
 * @property string $title
 * @property string $keywords
 * @property string $photoSrc
 * @property string $status
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['itemId', 'sku', 'categoryId', 'description', 'title', 'keywords', 'photoSrc', 'status'], 'required'],
            [['itemId', 'sku', 'categoryId'], 'string', 'max' => 21],
            [['description', 'title'], 'string', 'max' => 40],
            [['keywords', 'photoSrc'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 3],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['categoryId' => 'categoryId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemId' => 'Item ID',
            'sku' => 'Sku',
            'categoryId' => 'Category ID',
            'description' => 'Description',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'photoSrc' => 'Photo Src',
            'status' => 'Status',
        ];
    }
}