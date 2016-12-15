<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

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

    public function upload($folder = 'userpics')
    {
        // the path to save file, you can set an uploadPath
        // in Yii::$app->params (as used in example below)                       

        if ($this->validate()) {
            $path = '/uploads/'.$folder.'/';
            $basePath = Yii::$app->basePath . '/../frontend/web';
            
            if(isset($this->imageCover) && !empty($this->imageCover))
            {
                $name = Yii::$app->security->generateRandomString() . '.' . $this->imageCover->extension;
                $this->cover = $path.$name;
                $this->imageCover->saveAs($basePath . $this->cover);
            }

            if(isset($this->imageThumb) && !empty($this->imageThumb))
            {
                $name = Yii::$app->security->generateRandomString() . '.' . $this->imageThumb->extension;
                $this->thumbnail = $path.$name;
                $this->imageThumb->saveAs($basePath . $this->thumbnail);
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
        else
            $this->thumbnail = 'http://ondetem-gn.com.br' . $this->thumbnail;
        
        if(is_null($this->cover) || empty($this->cover))
            $this->cover = 'assets/img/generic-cover.jpg';
        else
            $this->cover = 'http://ondetem-gn.com.br' . $this->cover;
    }
}
