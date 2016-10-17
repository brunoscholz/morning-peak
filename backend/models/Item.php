<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

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
 * @property integer $status
 *
 * @property Category $category
 * @property Offer[] $offers
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

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
            [['categoryId', 'description', 'title', 'keywords', 'photoSrc', 'status'], 'required'],
            [['status'], 'integer'],
            [['itemId', 'sku', 'categoryId'], 'string', 'max' => 21],
            [['description', 'title'], 'string', 'max' => 40],
            [['keywords', 'photoSrc'], 'string', 'max' => 255],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['categoryId' => 'categoryId']],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemId' => 'ItemID',
            'sku' => 'Sku',
            'categoryId' => 'ID Categoria',
            'description' => 'Descrição',
            'title' => 'Nome',
            'keywords' => 'Palavras chave',
            'photoSrc' => 'Imagens',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffers()
    {
        return $this->hasMany(Offer::className(), ['itemId' => 'itemId']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $i = 0;
            $d = date();
            $images = $this->photoSrc . ',';

            foreach ($this->imageFiles as $file) {
                $name = 'uploads/' . $this->itemId . $d . $i . '.' . $file->extension;
                $images .= $name;
                $file->saveAs($name);
                $i++;
            }
            $this->save();
            return true;
        } else {
            return false;
        }
    }
}
