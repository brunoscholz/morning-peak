<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%subscription}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $createdAt
 * @property string $status
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [['createdAt', 'selector'], 'safe'],
            [['email'], 'string', 'max' => 80],
            [['status'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'selector' => 'Selector',
            'email' => 'Email',
            'createdAt' => 'Created At',
            'status' => 'Status',
        ];
    }

    public static function findBySelector($id)
    {
        return static::find()
            ->where(['like binary', 'selector', $id])
            ->one();
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($body)
    {
        return Yii::$app
            ->mailerc
            ->compose(
                'newsletterSubscriptionEmail-html',
                ['data' => $body]
            )
            ->setFrom(Yii::$app->params['contactEmail'])
            ->setTo($this->email)
            ->setSubject(Yii::$app->name . ' Newsletter')
            ->send();
    }
}
