<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "{{%picture}}".
 *
 * @property string $pictureId
 * @property string $cover
 * @property string $large
 * @property string $medium
 * @property string $thumbnail
 * @property string $status
 */
class Picture extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $imageCover;
    public $imageLarge;
    public $imageMedium;
    public $imageThumb;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%picture}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pictureId'], 'required'],
            [['pictureId'], 'string', 'max' => 21],
            [['cover', 'large', 'medium', 'thumbnail'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 3],
            [['imageCover'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageLarge'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageMedium'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageThumb'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pictureId' => 'Picture ID',
            'cover' => 'Cover',
            'large' => 'Large',
            'medium' => 'Medium',
            'thumbnail' => 'Thumbnail',
            'status' => 'Status',
        ];
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'pictureId', $id])
            ->one();
    }

    public function getPath($type)
    {
        return Yii::getAlias('@frontend/web') . $this->$type;
    }

    public function upload($folder = 'userpics')
    {
        // the path to save file, you can set an uploadPath
        // in Yii::$app->params (as used in example below)                       

        // delete old file!!!!!

        if ($this->validate()) {
            $path = '/uploads/'.$folder.'/';
            $basePath = Yii::$app->basePath . '/../frontend/web';

            if(isset($this->imageCover) && !empty($this->imageCover))
            {
                $name = Yii::$app->security->generateRandomString() . '.' . $this->imageCover->extension;
                $this->cover = $path.$name;
                //$this->imageCover->saveAs($basePath . $this->cover);
                $this->doResize($this->imageCover->tempName, 'COVER_SIZE', $basePath . $this->cover);
            }

            if(isset($this->imageThumb) && !empty($this->imageThumb))
            {
                $name = Yii::$app->security->generateRandomString() . '.' . $this->imageThumb->extension;
                $this->thumbnail = $path.$name;
                //$this->imageThumb->saveAs($basePath . $this->thumbnail);
                $this->doResize($this->imageThumb->tempName, 'THUMB_SIZE', $basePath . $this->cover);
            }

            if(isset($this->imageLarge) && !empty($this->imageLarge))
            {
                $name = Yii::$app->security->generateRandomString() . '.' . $this->imageLarge->extension;
                $this->large = $path.$name;
                $this->imageLarge->saveAs($basePath . $this->large);
            }

            if(isset($this->imageMedium) && !empty($this->imageMedium))
            {
                $name = Yii::$app->security->generateRandomString() . '.' . $this->imageMedium->extension;
                $this->medium = $path.$name;
                $this->imageMedium->saveAs($basePath . $this->medium);
            }

            $this->imageMedium = $this->imageLarge = $this->imageThumb = $this->imageCover = null;
            $this->save();
            return true;
        } else {
            return false;
        }
    }

    public function doResize($resizeImagePath, $type, $thumbImagePath)
    {
        list($width, $height) = $this->sizeArray[$type];

        $mem_limit = ini_get ('memory_limit');
        //ini_set ('display_errors', false);
        ini_set ('memory_limit', '400M');

        $imagine = Image::getImagine()
            ->open($resizeImagePath)
            ->thumbnail(new Box($width, $height))
            ->save($thumbImagePath, ['quality' => 90]);
            //->save(Yii::getAlias('@runtime/thumb-test-photo.jpg'), ['quality' => 80]);
        
        ini_set ('memory_limit',$mem_limit);
    }

    public $sizeArray = [
        'COVER_SIZE' => [592, 396],
        'THUMB_SIZE' => [256, 256],
    ];

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // ...custom code here...
            //http://ondetem-gn.com.br/uploads/userpics/4xsJ18K4J7dXr74jlWK_U--lvTY7tyF6.png
            $this->thumbnail = str_replace('http://ondetem-gn.com.br', '', $this->thumbnail);
            $this->cover = str_replace('http://ondetem-gn.com.br', '', $this->cover);

            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        if(is_null($this->thumbnail) || empty($this->thumbnail))
            $this->thumbnail = 'assets/img/generic-avatar.png';
        elseif (strpos($this->thumbnail, 'generic') != true)
            $this->thumbnail = 'http://ondetem-gn.com.br' . $this->thumbnail;
        
        if(is_null($this->cover) || empty($this->cover))
            $this->cover = 'assets/img/generic-cover.jpg';
        elseif (strpos($this->cover, 'generic') != true)
            $this->cover = 'http://ondetem-gn.com.br' . $this->cover;
    }
}
