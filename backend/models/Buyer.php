<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%buyer}}".
 *
 * @property string $buyerId
 * @property string $userId
 * @property string $pictureId
 * @property string $about
 * @property string $dob
 * @property string $firstname
 * @property string $lastname
 * @property string $gender
 * @property string $email
 * @property string $title
 * @property string $website
 * @property float $coinsBalance
 * @property string $url_facebook
 * @property string $url_googleplus
 * @property string $url_flickr
 * @property string $url_linkedin
 * @property string $url_twitter
 * @property string $url_vimeo
 * @property string $url_youtube
 * @property string $url_instagram
 *
 * @property User $user
 * @property Loyalty[] $loyalties
 */
class Buyer extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $imageCover;
    public $imageThumb;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%buyer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dob', 'name', 'gender', 'email'], 'required'],
            [['buyerId', 'userId', 'dob'], 'string', 'max' => 21],
            [['about'], 'string', 'max' => 420],
            [['name'], 'string', 'max' => 80],
            [['gender'], 'string', 'max' => 3],
            [['email', 'website'], 'string', 'max' => 60],
            [['title'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 3],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
            [['pictureId'], 'exist', 'skipOnError' => true, 'targetClass' => Picture::className(), 'targetAttribute' => ['pictureId' => 'pictureId']],
            [['imageCover'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageThumb'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'buyerId' => 'Buyer ID',
            'userId' => 'User ID',
            'pictureId' => 'Picture',
            'about' => 'About',
            'dob' => 'Birthday',
            'name' => 'Name',
            'gender' => 'Gender',
            'email' => 'Email',
            'title' => 'Title',
            'website' => 'Website',
            'coinsBalance' => 'Coins Balance',
            'createdAt' => 'Data Criação',
            'updatedAt' => 'Data Atualização',
            'status' => 'Status',
            'imageCover' => 'Capa',
            'imageThumb' => 'Avatar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['pictureId' => 'pictureId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoyalties()
    {
        return $this->hasMany(Loyalty::className(), ['buyerId' => 'buyerId']);
    }

    /*public function upload()
    {
        if ($this->validate()) {
            //$imagePath = '/root/path/to/image/folder/';
            $i = 0;
            $d = time().uniqid(rand());
            
            if(isset($this->imageCover) && !empty($this->imageCover))
            {
                // generate a unique file name to prevent duplicate filenames
                $model->image_web_filename = Yii::$app->security->generateRandomString().".{$ext}";
                // the path to save file, you can set an uploadPath
                // in Yii::$app->params (as used in example below)                       
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/status/';
                $path = Yii::$app->params['uploadPath'] . $model->image_web_filename;

                $name = 'uploads/userpics/' . $this->pictureId . $d . '_1.' . $this->imageCover->extension;
                $this->cover = $name;
                $this->imageCover->saveAs($name);
            }

            if(isset($this->imageThumb) && !empty($this->imageThumb))
            {
                $name = 'uploads/userpics/' . $this->pictureId . $d . '_2.' . $this->imageThumb->extension;
                $this->thumbnail = $name;
                $this->imageThumb->saveAs($name);
            }

            /*if(isset($this->imageLarge) && !empty($this->imageLarge))
            {
                $name = 'uploads/userpics/' . $this->pictureId . $d . '_3.' . $this->imageLarge->extension;
                $this->large = $name;
                $this->imageLarge->saveAs($name);
            }

            if(isset($this->imageMedium) && !empty($this->imageMedium))
            {
                $name = 'uploads/userpics/' . $this->pictureId . $d . '_4.' . $this->imageMedium->extension;
                $this->medium = $name;
                $this->imageMedium->saveAs($name);
            }*

            $this->save();
            return true;
        } else {
            return false;
        }
    }*/
}
