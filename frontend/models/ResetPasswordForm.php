<?php
namespace frontend\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $confirmPassword;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }

        $this->_user = User::findByPasswordResetToken($token);

        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'confirmPassword'], 'required'],
            [['password', 'confirmPassword'], 'string', 'min' => 8, 'max' => 60],
            [['password'], 'validatePassword'],
            [['confirmPassword'], 'checkNewPassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        // ^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d,.;:]).+$
        // (?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
        if (preg_match('/^(?=.*\d).*$/', !$this->$attribute)) {
            $this->addError($attribute, 'Senha incorreta.');
        }
    }

    public function checkNewPassword($attribute, $params)
    {
        if($this->password != $this->$attribute)
            $this->addError($attribute, 'As senhas não conferem');
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Nova Senha',
            'confirmPassword' => 'Confirmar Senha',
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
