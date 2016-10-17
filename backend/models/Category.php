<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $categoryId
 * @property string $parentId
 * @property string $name
 * @property string $description
 * @property string $icon
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property Item[] $items
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
    public function rules()
    {
        return [
            [['name', 'description', 'icon'], 'required'],
            [['categoryId', 'parentId'], 'string', 'max' => 21],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 40],
            [['parentId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parentId' => 'categoryId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryId' => 'ID Categoria',
            'parentId' => 'ID SuperCategoria',
            'name' => 'Nome',
            'description' => 'Descrição',
            'icon' => 'Ícone',
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
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['categoryId' => 'categoryId']);
    }
}
