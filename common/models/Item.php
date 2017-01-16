<?php

namespace common\models;

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
    public static function primaryKey()
    {
        return ['itemId'];
    }

    public function fields()
    {
        $fields = parent::fields();
        return $fields;
    }

    public function extraFields()
    {
        return ['category'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['itemId', 'categoryId', 'description', 'title', 'status'], 'required'],
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
            'categoryId' => 'Categoria',
            'description' => 'Descrição',
            'title' => 'Nome',
            'keywords' => 'Tags',
            'photoSrc' => 'Photo Src',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['categoryId' => 'categoryId']);
    }
}
