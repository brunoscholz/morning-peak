<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Buyer;
use common\models\AuthToken;
use common\models\SocialAccount;
use common\models\Picture;
use api\components\RestUtils;
use yii\base\Model;
use yii\widgets\ActiveForm;

class AuthModel extends Model
{
    const SIGNIN_SCENARIO = "signinScenario";
    const SIGNUP_SCENARIO = "signupScenario";
    const SOCIAL_SCENARIO = "socialScenario";

	private $_user;
    private $_buyer;
    private $_authToken;
    private $_socialAccount;
    private $_picture;
    private $_socialPicture;

    public $token;
    public $socialId;
    public $socialName;

    public $_authenticator;
    public $username;
    public $password;

    public $name;
    public $confirmPassword;
    public $terms;

    public function rules()
    {
        return [
            [['User', 'Buyer', 'AuthToken', 'SocialAccount', 'Picture'], 'required'],
            // SIGN IN
            [['AuthToken', 'token'], 'required', 'when' => function($model) {
                return !$model->socialId && $model->scenario == self::SIGNIN_SCENARIO;
            }],
            [['SocialAccount', 'socialId'], 'required', 'when' => function($model) {
                return !$model->token && $model->scenario == self::SIGNIN_SCENARIO;
            }],
            [['username', 'password'], 'required', 'when' => function($model) {
                return !$model->socialId && !$model->token && $model->scenario == self::SIGNIN_SCENARIO;
            }],

            [['socialId', 'token', 'name', 'username', 'socialName'], 'string'],
            //[['terms'], 'integer'],


            [['password', 'confirmPassword'], 'string', 'min' => 8, 'max' => 60],
            [['password'], 'validatePassword'],
            [['confirmPassword'], 'checkNewPassword'],
            [['username', 'password'], 'required'],

        ];
    }

    /*public function validateCurrentPassword($attribute, $params)
    {
        if(!$this->user->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Senha incorreta.');
        }
    }*/

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

    public function afterValidate()
    {
    	$error = false;
        if($this->scenario == self::SIGNUP_SCENARIO && !$this->picture->validate()) {
            $error = true;
        }
        if($this->scenario == self::SIGNUP_SCENARIO && !$this->buyer->validate()) {
            $error = true;
        }
        if(!$this->user->validate()) {
            $error = true;
        }
        if(!$this->authToken->validate()) {
            $error = true;
        }
        if(!is_null($this->socialAccount) && !$this->socialAccount->validate()) {
            $error = true;
        }

    	if($error)
    		$this->addError(null);

    	parent::afterValidate();
    }

    public function save()
    {
    	if(!$this->validate()) {
    		return false;
    	}

        try {

        	$tx = Yii::$app->db->beginTransaction();

            if($this->scenario == self::SIGNUP_SCENARIO)
                $this->picture->save();
            if($this->scenario == self::SIGNUP_SCENARIO)
                $this->buyer->save();
            $this->user->save();

            $this->authToken->save();

            if(!is_null($this->socialAccount))
                $this->socialAccount->save();


        	$tx->commit();
        	return true;

        } catch(Exception $e) {
            $tx->rollBack();
            return false;
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SIGNIN_SCENARIO] = ['User'];
        $scenarios[self::SIGNUP_SCENARIO] = ['User', 'Buyer', 'Picture', 'name', 'username', 'password', 'confirmPassword', 'terms'];
        $scenarios[self::SOCIAL_SCENARIO] = ['User', 'SocialAccount'];
        return $scenarios;
    }

    public function signIn($params)
    {
        $this->load($params);
        $this->scenario = self::SIGNIN_SCENARIO;
    }

    public function signUp($params)
    {
        $this->load($params);

        if($this->socialId) {
            $this->name = $params['AuthModel']['name'];
            $this->username = $params['AuthModel']['email'];
            $this->password = RestUtils::getToken(8);
            $this->confirmPassword = $this->password;
            $this->terms = $params['AuthModel']['terms'] == true ? 1 : 0;
            if($this->terms == 0)
                $this->addError('AuthModel', 'O novo usuário deve aceitar os termos para se cadastrar.');
            $this->_socialPicture = $params['AuthModel']['picture'];
        }

        $this->scenario = self::SIGNUP_SCENARIO;
    }

    public function socialConnect($params)
    {
        $this->load($params);

        $this->scenario = self::SOCIAL_SCENARIO;
    }

    public function authenticate()
    {
        $this->user->lastLogin = date('Y-m-d\TH:i:s');
        if(!$this->token)
            $this->authToken = $this->createToken();

        return $this->save();
    }

    public function checkSignUp($params)
    {
        
    }

    public function register()
    {
        $this->user = User::findByUsername($this->username);
        if(!is_null($this->user) && !$this->socialId)
        {
            $this->addError('User', 'Usuário já existe com email cadastrado.');
            return false;
        }
        elseif(!is_null($this->user))
        {
            // user exists
            // register social
            $this->buyer = $this->user->buyer;
            //$this->picture = $this->buyer->picture;
            $this->picture = Picture::findById($this->buyer->picture->pictureId);
            foreach($this->user->social as $acc)
            {
                if($acc->externalId == $this->socialId && $acc->name == $this->socialName) {
                    $this->socialAccount = $acc;
                    break;
                }

            }

            if(!$this->SocialAccount)
                $this->socialAccount = $this->createSocialAccount();
        }
        else
        {
            // register normal
            $this->buyer = $this->createBuyer($this->name, $this->username);
            $this->user = $this->createUser($this->buyer, $this->password);
            $this->picture = new Picture();
            $this->picture->pictureId = RestUtils::generateId();
            if($this->socialId)
                $this->picture->thumbnail = $this->_socialPicture;
            //$this->_authenticator = RestUtils::getToken(33);
        }

        return $this->authenticate();
    }

    public function validateAuth()
    {
        if($this->socialId) {
            return $this->validateSocial($this->socialId);
        } elseif($this->token) {
            return $this->validateToken($this->token);
        } else {
            return $this->validateUsername();
        }
    }

    public function validateUsername()
    {
        $this->user = User::findByUsername($this->username);

        if(is_null($this->user)) {
            $this->addError('User', 'Usuário não encontrado.');
            return false;
        }

        if(!$this->user->validatePassword($this->password)) {
            $this->addError('User', 'Usuário ou senha incorretos.');
            return false;
        }

        return true;
    }

    public function validateToken($token)
    {
        list($selector, $authenticator) = explode(':', $token);
        $this->_authenticator = $authenticator;

        $this->authToken = AuthToken::findBySelector($selector);

        if(is_null($this->authToken)) {
            // $models['status'] = AuthToken::TOKEN_MISSING; // 404
            var_dump($this->authToken);
            $this->addError('AuthToken', 'Token não encontrado.');
            return false;
        }
        if(strtotime($this->authToken->expires) < strtotime(date('Y-m-d H:i:s'))) {
            // $models['status'] = AuthToken::TOKEN_EXPIRED; // 401
            $this->addError('AuthToken', 'Token expirado.');
            return false;
        }

        if(RestUtils::hash_equals($this->authToken->token, hash('sha256', base64_decode($this->_authenticator)))) {
            // logged in
            $this->user = User::findById($this->authToken->userId);

            if(is_null($this->user))
            {
                // $models['status'] = AuthToken::USER_MISSING;
                $this->addError('User', 'Usuário não encontrado.');
                return false;
            }
        }

        return true;
    }

    public function validateSocial($id)
    {
        //$this->socialId = $id;
        $this->socialAccount = SocialAccount::findByExternalId($this->socialId);
        if(is_null($this->socialAccount)) {
            $this->addError('SocialAccount', 'Conta externa não encontrada.');
            return false;
        }

        $this->user = User::findById($this->socialAccount->userId);

        if(is_null($this->user))
        {
            // $models['status'] = AuthToken::USER_MISSING;
            $this->addError('User', 'Usuário não encontrado.');
            return false;
        }

        return true;
    }

    public function getUser()
    {
    	return $this->_user;
    }

    public function setUser($user)
    {
        $this->_user = $user;
    }

    public function getBuyer()
    {
        return $this->_buyer;
    }

    public function setBuyer($buyer)
    {
        $this->_buyer = $buyer;
    }    

    public function getPicture()
    {
        return $this->_picture;
    }

    public function setPicture($pic)
    {
        $this->_picture = $pic;
    }

    public function getAuthToken()
    {
        return $this->_authToken;
    }

    public function setAuthToken($tk)
    {
        $this->_authToken = $tk;
    }

    public function getSocialAccount()
    {
        return $this->_socialAccount;
    }

    public function setSocialAccount($sa)
    {
        $this->_socialAccount = $sa;
    }

    public function errorSummary($form)
    {
    	$errorLists = [];
    	foreach ($this->getAllModels() as $id => $model) {
    		$errorList = $form->errorSummary($model, [
    			'header' => '<p>Os seguintes campos possuem erros: <b>'.$id.'</b></p>',
			]);
			$errorList = str_replace('<li></li>', '', $errorList); // remove the empty error
            $errorLists[] = $errorList;
    	}
    	return implode('', $errorLists);
    }

    public function errorList()
    {
        $errorLists = [];
        foreach ($this->getAllModels() as $id => $model) {
            if($model)
                $errorLists[$id] = $model->errors;
        }
        $errorLists['AuthModel'] = $this->errors;
        return RestUtils::arrayCleaner($errorLists);
    }

    public function firstError()
    {
        $ret = $this->errorList();

        while(is_array($ret))
            $ret = reset($ret);

        return $ret;
    }

    public function resultMessage()
    {
        return $this->returnMsg;
    }

    private function getAllModels()
    {
    	return [
            'User' => $this->user,
            'Buyer' => $this->buyer,
            'Picture' => $this->picture,
            'AuthToken' => $this->authToken,
            'SocialAccount' => $this->socialAccount,
    	];
    }

    private function createToken()
    {
        $authenticator = RestUtils::getToken(33);

        $am = new AuthToken(['scenario' => 'register']);
        $am->authTokenId = RestUtils::generateId();
        $am->userId = $this->user->userId;
        $am->selector = base64_encode(RestUtils::getToken(9));
        $am->token = hash('sha256', $authenticator);
        $am->expires = date('Y-m-d\TH:i:s', strtotime('+6 months'));
        //$am->expires = date('Y-m-d\TH:i:s', time() + 864000); //(7 * 24 * 60 * 60)
        $this->token = $am->selector.':'.base64_encode($authenticator);
        return $am;
    }

    private function createSocialAccount()
    {
        $social = new SocialAccount(['scenario' => 'register']);
        $social->socialId = RestUtils::generateId();
        $social->userId = $this->user->userId;
        $social->externalId = $this->socialId;
        $social->name = $this->socialName;
        $social->status = 'ACT';
        return $social;
    }

    protected function createBuyer($name, $email)
    {
        $buyer = new Buyer();
        $buyer->buyerId = RestUtils::generateId();
        $buyer->name = $name;
        $buyer->email = strtolower($email);
        $buyer->createdAt = date('Y-m-d\TH:i:s');
        $buyer->status = "INC";
        return $buyer;
    }

    protected function createUser($buyer, $pass, $status = User::STATUS_ACTIVE)
    {
        $user = new User(['scenario' => 'register']);
        $user->userId = RestUtils::generateId();
        $user->email = strtolower($buyer->email);
        $user->buyerId = $buyer->buyerId;
        $user->role = User::ROLE_USER;
        $user->vendor = 0;
        $user->visibility = "NOR";
        //$user->createdAt = date('Y-m-d\TH:i:s');
        $user->lastLogin = date('Y-m-d\TH:i:s');
        $user->status = $status;
        $user->setPassword($pass);
        return $user;
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail()
    {
        if (!$this->user || !$this->user->isNewRecord) {
            return false;
        }

        return Yii::$app
            ->mailers
            ->compose(
                ['html' => 'newUser-html'],
                ['user' => $this->user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->user->email)
            ->setSubject(Yii::$app->name . ' - Novo Cadastro')
            ->send();
    }
}