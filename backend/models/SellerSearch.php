<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%seller}}".
 *
 * @property string $sellerId
 * @property string $userId
 * @property string $about
 * @property string $name
 * @property string $email
 * @property string $website
 * @property string $hours
 * @property string $categories
 * @property string $paymentOptions
 *
 * @property User $user
 * @property Offer[] $offers
 */
class Seller extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'ACT';
    const STATUS_NOT_VERIFIED = 'PEN';
    const STATUS_WAITING_PAY = 'PAY';
    const STATUS_BANNED = 'BAN';

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
        return '{{%seller}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['sellerId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['about', 'name', 'email'], 'required'],
            [['sellerId', 'userId'], 'string', 'max' => 21],
            [['about'], 'string', 'max' => 420],
            [['name', 'email', 'website'], 'string', 'max' => 60],
            [['hours', 'categories'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 3],
            //[['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
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
            'sellerId' => 'ID Empresa',
            'userId' => 'UserID',
            'pictureId' => 'PictureID',
            'about' => 'Sobre',
            'name' => 'Nome Fantasia',
            'email' => 'Email Contato (pode ser o mesmo do cadastro)',
            'website' => 'Website',
            'hours' => 'Horário de Funcionamento',
            'phone' => 'Fone',
            'cellphone' => 'Celular',
            'categories' => 'Categorias',
            'paymentOptions' => 'Opções de Pagamento',
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
    public function getOffers()
    {
        return $this->hasMany(Offer::className(), ['sellerId' => 'sellerId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['pictureId' => 'pictureId']);
    }

    public function getReviews()
    {
        return $this->hasMany(ReviewFact::className(), ['sellerId' => 'sellerId']);
    }
}
