<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_category".
 *
 * @property string $categoryId
 * @property string $parentId
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $status
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['categoryId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryId', 'name', 'description', 'icon'], 'required'],
            [['categoryId', 'parentId'], 'string', 'max' => 21],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 40],
            [['status'], 'string', 'max' => 3],
            [['parentId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parentId' => 'categoryId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryId' => 'Category ID',
            'parentId' => 'Categoria Pai',
            'name' => 'Nome',
            'description' => 'Descrição',
            'icon' => 'Ícone',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['categoryId' => 'parentId']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parentId' => 'categoryId']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffers()
    {
        return $this->hasMany(Offer::className(), ['itemId' => 'itemId'])
            ->via('items');
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), ['categoryId' => 'categoryId']);
    }
}
