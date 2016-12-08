<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%auth_token}}".
 *
 * @property string $authTokenId
 * @property string $userId
 * @property string $selector
 * @property string $token
 * @property string $expires
 */
class AuthToken extends \yii\db\ActiveRecord
{
    const TOKEN_EXPIRED = 401;
    const TOKEN_WRONG = 403;
    const TOKEN_MISSING = 404;
    const USER_WRONG = 301;
    const USER_MISSING = 304;
    //const TOKEN_MISSING = 404;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_token}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['authTokenId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['authTokenId', 'userId'], 'required'],
            [['expires'], 'safe'],
            [['authTokenId', 'userId'], 'string', 'max' => 21],
            [['selector'], 'string', 'max' => 12],
            [['token'], 'string', 'max' => 64],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'authTokenId' => 'Auth Token ID',
            'userId' => 'User ID',
            'selector' => 'Selector',
            'token' => 'Token',
            'expires' => 'Expires',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
        //->from(['sender' => User::tableName()]);
    }

    public static function findByUser($id)
    {
        //->andWhere(['>', 'expires', date('Y-m-d h:i:s')])
        return static::find()
            ->where(['like binary', 'userId', $id])
            ->one();
    }

    public static function findBySelector($id)
    {
        return static::find()
            ->where(['like binary', 'selector', $id])
            ->one();
    }

    public static function findByToken($token)
    {
        //->andWhere(['>', 'expires', date('Y-m-d h:i:s')])
        return static::find()
            ->where(['like binary', 'token', $token])
            ->one();
    }
}
