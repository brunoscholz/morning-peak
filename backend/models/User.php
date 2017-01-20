<?php

namespace backend\models;

use Yii;
use common\models\Buyer;
use common\models\User as UserModel;
use backend\components\Utils;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%tbl_user}}".
 *
 * @property string $userId
 * @property string $username
 * @property string $email
 * @property string $about
 * @property string $lastLogin
 * @property string $lastLoginIp
 * @property string $role
 * @property string $password
 * @property integer $requiresNewPassword
 * @property string $resetKey
 * @property string $resetToken
 * @property string $salt
 * @property string $activation_key
 * @property string $validation_key
 * @property string $avatar
 * @property string $paletteId
 * @property string $publicKey
 * @property integer $vendor
 * @property string $visibility
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property VitUsermeta[] $vitUsermetas
 */
class User extends UserModel implements IdentityInterface
{
    public static function findIdentity($id)
    {
        //return static::findOne($id);
        return static::findOne(['userId' => $id]); //'status' => self::STATUS_ACTIVE
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public function getId()
    {
        return $this->userId;
    }
    public function getAuthKey()
    {
        return "";
    }
    public function validateAuthKey($authKey)
    {
        return true;
    }

    public static function findById($id)
    {
        return static::find()
            ->where(['like binary', 'userId', $id])
            ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $query = User::find()
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->andWhere(['email' => $username]);

        return $query->one();
    }

    /**
     * Finds user by activation token
     *
     * @param string $token activation key selector
     * @return static|null
     */
    public static function findByActivationKey($token)
    {
        /*if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }*/

        return static::find()
            ->where(['like binary', 'activation_key', $token])
            ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'resetToken' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->resetToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->resetToken = null;
    }

    public function verifyKeys($activationKey)
    {
        return $this->validation_key === hash('sha256', base64_decode($activationKey));
    }

    public function validatePassword($password)
    {
        $hashedPass = Utils::hashPassword($password, $this->salt);
        return $hashedPass === $this->password;
    }
}
