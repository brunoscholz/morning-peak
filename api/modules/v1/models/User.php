<?php

namespace api\modules\v1\models;

use Yii;

/**
 * User Model
 * This is the model class for table "{{%user}}".
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    // explicitly list every field, best used when you want to make sure the changes
    // in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password'], $fields['passwordStrategy'], $fields['resetToken'], $fields['salt'], $fields['activation_key'], $fields['validation_key']);
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'username', 'email', 'about', 'lastLogin', 'lastLoginIp', 'role', 'password', 'passwordStrategy', 'resetToken', 'salt', 'activation_key', 'validation_key', 'avatar', 'paletteId', 'publicKey', 'vendor', 'visibility', 'status', 'createdAt', 'updatedAt'], 'required'],
            [['role'], 'string'],
            [['requiresNewPassword', 'vendor'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['userId', 'username', 'lastLogin', 'paletteId'], 'string', 'max' => 21],
            [['email', 'avatar'], 'string', 'max' => 60],
            [['about', 'password', 'resetToken', 'salt', 'validation_key', 'publicKey'], 'string', 'max' => 255],
            [['lastLoginIp'], 'string', 'max' => 32],
            [['passwordStrategy'], 'string', 'max' => 50],
            [['activation_key'], 'string', 'max' => 128],
            [['visibility', 'status'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'username' => 'Username',
            'email' => 'Email',
            'about' => 'About',
            'lastLogin' => 'Last Login',
            'lastLoginIp' => 'Last Login Ip',
            'role' => 'Role',
            'password' => 'Password',
            'passwordStrategy' => 'Password Strategy',
            'requiresNewPassword' => 'Requires New Password',
            'resetToken' => 'Reset Token',
            'salt' => 'Salt',
            'activation_key' => 'Activation Key',
            'validation_key' => 'Validation Key',
            'avatar' => 'Avatar',
            'paletteId' => 'Palette ID',
            'publicKey' => 'Public Key',
            'vendor' => 'Vendor',
            'visibility' => 'Visibility',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
