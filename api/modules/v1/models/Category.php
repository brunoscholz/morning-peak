<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "tbl_category".
 *
 * @property string $categoryId
 * @property string $parentId
 * @property string $name
 * @property string $description
 * @property string $icon
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_category';
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryId' => 'Category ID',
            'parentId' => 'Parent ID',
            'name' => 'Name',
            'description' => 'Description',
            'icon' => 'Icon',
        ];
    }
}