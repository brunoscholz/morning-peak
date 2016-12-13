<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%social_account}}".
 *
 * @property string $socialId
 * @property string $userId
 * @property string $externalId
 * @property string $name
 * @property string $status
 */
class SocialAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%social_account}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['socialId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['socialId', 'externalId', 'name'], 'required'],
            [['socialId', 'userId'], 'string', 'max' => 21],
            [['externalId'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 3],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'socialId' => 'Social ID',
            'userId' => 'User ID',
            'externalId' => 'External ID',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }

    public function getUser()
    {
        //return $this->hasOne(User::className(), ['userId' => 'userId']);
        //->from(['sender' => User::tableName()]);
    }

    public static function findByUser($id)
    {
        //->andWhere(['>', 'expires', date('Y-m-d h:i:s')])
        return static::find()
            ->where(['like binary', 'userId', $id])
            ->one();
    }

    public static function findByExternalId($id)
    {
        return static::find()
            ->where(['like binary', 'externalId', $id])
            ->one();
    }
}
