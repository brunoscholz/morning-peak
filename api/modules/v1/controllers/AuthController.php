<?php

namespace api\modules\v1\controllers;

use yii\swiftmailer\Mailer;
use yii\db\Query;
use api\modules\v1\models\Buyer;
use api\modules\v1\models\Seller;
use api\modules\v1\models\User;
use api\modules\v1\models\AuthToken;
use api\modules\v1\models\SocialAccount;
use api\modules\v1\models\AssetToken;
use api\modules\v1\models\Transaction;
use api\modules\v1\models\Loyalty;
use api\modules\v1\models\Relationship;
use api\modules\v1\models\ActionReference;
use api\modules\v1\models\BillingAddress;
use api\components\RestUtils;
use \backend\models\Picture;

/**
 * AuthController API (extends \yii\rest\ActiveController)
 * AuthController is the controller responsible for doing the access verifications.
 * and create basic, activation dependent, new models for users
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class AuthController extends \yii\rest\ActiveController
{
    protected $API_VERSION = 'v1';
    protected $APP_VERSION = 'v1.4.2';

    /**
     * @internal typical override of ActiveController 
     *
     */
    public $modelClass = 'api\modules\v1\models\User';

    /**
     * @internal typical override of ActiveController 
     *
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    /**
     * POST /auth/signin
     * If token is received, it is verified against authToken table and if not expired, returns ok to login
     *
     * If username and password are received, it verifies the password against the user table. If everything is ok, it creates a authToken and returns it
     *
     * @example {token:NkhEQ0RSd2dV:bWx1NzlEUHNnMUc1Tk5pa3hDTGlqcE1JNzd3RHE5NnFh}
     * @example { username:user@mailserver.com, password:strongpass }
     * @return json @see api\modules\v1\models\AuthToken for the statuses
     */
    public function actionSignin()
    {
    	$params = \Yii::$app->request->post();
    	$models = array('status'=>500);
        $models['error'] = 'Erro no servidor';

        if(isset($params['fbId']) && !empty($params['fbId']))
        {
            $fbId = $params['fbId'];
            $social = SocialAccount::findByExternalId($fbId);
            $user = User::findByUsername($params['email']);
            if(is_null($social) && is_null($user))
            {
                // SignUp
                $buyer = $this->createBuyer($params['email'], $params['name']);
                $user = $this->createUser($buyer, $fbId);
                $authenticator = RestUtils::getToken(33);
                $authModel = $this->createAuthToken($user, $authenticator);
                $social = $this->createSocialAccount($user, $fbId);
                $models['firstLogin'] = 1;

                $user->lastLogin = date('Y-m-d\TH:i:s');
                //$picture = createPicture();

                $res = $this->validateAndSave([$buyer, $user, $authModel, $social]);
                if(isset($res['error']))
                {
                    $models['status'] = 500;
                    $models['error'] = $res['error'];
                    $models['errorLog'] = $res['errorLog'];
                }
                else
                {
                    $temp = $this->fetchUser($user);
                    $models['status'] = 200;
                    $models['data'] = [$temp];
                    $models['token'] = $authModel->selector.':'.base64_encode($authenticator);
                    unset($models['error']);
                }

            }
            elseif(is_null($user)) {}
            elseif(is_null($social))
            {
                // Connect Facebook
                $authenticator = RestUtils::getToken(33);
                $authModel = $this->createAuthToken($user, $authenticator);
                $social = $this->createSocialAccount($user, $fbId);
                $user->lastLogin = date('Y-m-d H:i:s');
                
                $res = $this->validateAndSave([$user, $authModel, $social]);

                if(isset($res['error']))
                {
                    $models['status'] = 500;
                    $models['error'] = $res['error'];
                    $models['errorLog'] = $res['errorLog'];
                }
                else
                {
                    $temp = $this->fetchUser($user);
                    $models['status'] = 200;
                    $models['data'] = [$temp];
                    $models['token'] = $authModel->selector.':'.base64_encode($authenticator);
                    unset($models['error']);
                }

            }
            else
            {
                $authenticator = RestUtils::getToken(33);
                $authModel = $this->createAuthToken($user, $authenticator);
                $user->lastLogin = date('Y-m-d\TH:i:s');

                $res = $this->validateAndSave([$user, $authModel]);
                if(isset($res['error']))
                {
                    $models['status'] = 500;
                    $models['error'] = $res['error'];
                    $models['errorLog'] = $res['errorLog'];
                }
                else
                {
                    $temp = $this->fetchUser($user);
                    $models['status'] = 200;
                    $models['data'] = [$temp];
                    $models['token'] = $authModel->selector.':'.base64_encode($authenticator);
                    unset($models['error']);
                }
            }

        }
        elseif(isset($params['token']) && !empty($params['token']))
        {
            // remember me auto login
            //NkhEQ0RSd2dV:bWx1NzlEUHNnMUc1Tk5pa3hDTGlqcE1JNzd3RHE5NnFh
            $token = $params['token'];
            $res = $this->checkAuthToken($params['token']);

            if(isset($res['error']))
            {
                $models['status'] = $res['status'];
                $models['error'] = $res['error'];
            }
            else
            {
                $auth = $res['auth'];
                // change last login in user table
                $user = User::findById($auth->userId);
                $user->lastLogin = date('Y-m-d\TH:i:s');
                $user->save();

                $temp = $this->fetchUser($user);

    			$models['status'] = 200;
    			$models['data'] = [$temp];
                $models['token'] = $token;
                unset($models['error']);
    		}

    	}
    	elseif(isset($params['username']) && isset($params['password']))
		{
			$user = User::findByUsername($params['username']);
			if(is_null($user))
			{
				$models['status'] = AuthToken::USER_MISSING;
                $models['error'] = 'Usuário ou senha incorretos';
			}
			elseif($user->validatePassword($params['password']))
			{
				// if remember me...
				$authenticator = RestUtils::getToken(33);
                $authModel = $this->createAuthToken($user, $authenticator);
				$authModel->save();

				// change last login in user table
				$user->lastLogin = date('Y-m-d\TH:i:s');
    			$user->save();

                $temp = $this->fetchUser($user);

                $models['status'] = 200;
                $models['data'] = [$temp];
                $models['token'] = $authModel->selector.':'.base64_encode($authenticator);
                unset($models['error']);
			}
			else
			{
				$models['status'] = AuthToken::USER_WRONG;
                $models['error'] = 'Usuário ou senha incorretos';
			}
		}

        echo RestUtils::sendResult($models['status'], $models);
    }

    /**
     * POST /auth/signup
     *
     * Receives the user info
     * 
     */
    public function actionSignup()
    {
    	$params = \Yii::$app->request->post();
    	$models = array('status'=>500);
        $models['error'] = 'Erro no servidor';

        $check = User::findByUsername($params['username']);
        if(!is_null($check))
        {
            $models['status'] = User::USER_EXISTS;
            $models['error'] = 'Email já cadastrado';
        }
        else
        {
            $buyer = $this->createBuyer($params['username'], $params['name']);
            $user = $this->createUser($buyer, $params['password']);
            $authenticator = RestUtils::getToken(33);
            $authModel = $this->createAuthToken($user, $authenticator);
            $models['firstLogin'] = 1;

            $res = $this->validateAndSave([$buyer, $user, $authModel]);
            if(isset($res['error']))
            {
                $models['status'] = 500;
                $models['error'] = $res['error'];
                $models['errorLog'] = $res['errorLog'];
            }
            else
            {
                $temp = $this->fetchUser($user);
                $models['status'] = 200;
                $models['data'] = [$temp];
                $models['token'] = $authModel->selector.':'.base64_encode($authenticator);
                unset($models['error']);
            }
        }

        echo RestUtils::sendResult($models['status'], $models);
    }

    protected function createUser($buyer, $pass, $status = User::STATUS_ACTIVE)
    {
        $user = new User();
        $user->userId = RestUtils::generateId();
        $user->email = $buyer->email;
        $salt = RestUtils::generateSalt();
        $user->role = User::ROLE_USER;
        $user->vendor = 0;
        $user->visibility = "NOR";
        $user->buyerId = $buyer->buyerId;
        $user->createdAt = date('Y-m-d\TH:i:s');
        $user->lastLogin = date('Y-m-d\TH:i:s');
        $user->status = $status;
        
        if($pass !== '' && !empty($pass))
        {
            $user->salt = $salt;
            $user->password = User::hashPassword($pass, $salt);
        }
        
        return $user;
    }

    protected function createBuyer($email, $name)
    {
        $buyer = new Buyer();
        $buyer->buyerId = RestUtils::generateId();
        $buyer->name = $name;
        $buyer->email = $email;
        $buyer->createdAt = date('Y-m-d\TH:i:s');
        $buyer->status = "INC";
        return $buyer;
    }

    protected function createSeller($user, $params, $status = User::STATUS_ACTIVE)
    {
        $seller = new Seller();
        $seller->sellerId = RestUtils::generateId();
        $seller->userId = $user->userId;
        $seller->name = $params['name'];
        $seller->about = $params['about'];
        $seller->email = $user->email;
        $seller->phone = $params['phone'];
        $seller->cellphone = $params['cellphone'];
        $seller->createdAt = date('Y-m-d\TH:i:s');
        $seller->status = $status;
        return $seller;
    }

    protected function createAuthToken($user, $authenticator)
    {
        $authModel = new AuthToken();
        $authModel->authTokenId = RestUtils::generateId();
        $authModel->userId = $user->userId;
        $authModel->selector = base64_encode(RestUtils::getToken(9));
        $authModel->token = hash('sha256', $authenticator);
        $authModel->expires = date('Y-m-d\TH:i:s', strtotime('+6 months'));
        //$authModel->expires = date('Y-m-d\TH:i:s', time() + 864000); //(7 * 24 * 60 * 60)
        return $authModel;
    }

    protected function createSocialAccount($user, $scId, $scName = 'facebook')
    {
        $social = new SocialAccount();
        $social->socialId = RestUtils::generateId();
        $social->userId = $user->userId;
        $social->externalId = $scId;
        $social->name = $scName;
        $social->status = 'ATV';
        return $social;
    }

    protected function checkAuthToken($token)
    {
        $models = array('status' => AuthToken::TOKEN_MISSING);
        list($selector, $authenticator) = explode(':',$token);
        $auth = AuthToken::findBySelector($selector);

        if(is_null($auth))
        {
            // 404
            $models['status'] = AuthToken::TOKEN_MISSING;
            $models['error'] = 'Token não encontrado';
        }
        elseif(strtotime($auth->expires) < strtotime(date('Y-m-d H:i:s')))
        {
            // 401
            $models['status'] = AuthToken::TOKEN_EXPIRED;
            $models['error'] = 'Token inválido';
        }
        else
        {
            if(hash_equals($auth->token, hash('sha256', base64_decode($authenticator))))
            {
                $models['status'] = 200;
                $models['auth'] = $auth;
            }
            else
            {
                $models['status'] = AuthToken::USER_WRONG;
                $models['error'] = 'Usuário ou senha incorretos';
            }
        }

        return $models;
    }

    protected function fetchUser($user)
    {
        $temp = RestUtils::loadQueryIntoVar($user);
        $temp['social'] = RestUtils::loadQueryIntoVar($user->social);

        $flwr = RestUtils::loadQueryIntoVar($user->buyer->followers);
        $temp['buyer']['followers'] = $flwr;

        $flwg = RestUtils::loadQueryIntoVar($user->buyer->following);
        $temp['buyer']['following'] = $flwg;

        $favs = RestUtils::loadQueryIntoVar($user->buyer->favorites);
        $temp['buyer']['favorites'] = $favs;

        $temp['sellers'] = array();
        foreach ($user->sellers as $seller)
        {
            $sel = RestUtils::loadQueryIntoVar($seller);
            $flwr = RestUtils::loadQueryIntoVar($seller->followers);
            $sel['followers'] = $flwr;
            $temp['sellers'][] = $sel;
        }

        return $temp;
    }

    protected function validateAndSave($models)
    {
        $ret = array('status' => 200);

        foreach($models as $model)
        {
            if(!$model->validate()) {
                $ret['status'] = 500;
                $ret['error'] = 'Erro de validação das informações';
                $ret['errorLog'][] = $model->errors;
            }
            else
                if(!$model->save()) {
                    $ret['status'] = 500;
                    $ret['error'] = 'Erro ao salvar informações';
                    $ret['errorLog'][] = $model->errors;
                }
        }

        return $ret;
    }

    /**
     * POST /auth/social-connect
     *
     * Receives the user's social info
     * If user exists updates the info and creates a socialAccount register
     * If not, sign up the user with the info provided
     * 
     */
    public function actionSocialConnect()
    {
    	$params = \Yii::$app->request->post();
    	$models = array('status'=>500);

    	if(isset($params['facebook'])){}
    }

    /**
     * POST /auth/seller-register
     *
     * Receives the new seller (customer) info and the salesperson who made the contact
     * Creates the user, buyer, and seller models
     * Creates a transaction with 1 SALE coin to the salesperson
     * Sends an email to the new seller (customer) with information about activating the account
     * 
     */
    public function actionSellerRegister()
    {
 	   	$params = \Yii::$app->request->post();
    	$models = array('status'=>500);

        $user = User::findByUsername($params['email']);
        $buyer = null;
        if(is_null($user))
        {
            $buyer = $this->createBuyer($params['name'], $params['email']);
            $user = $this->createUser($buyer, '', User::STATUS_NOT_VERIFIED);

        	$user->activation_key = RestUtils::generateActivationKey();
            $user->validation_key = RestUtils::generateValidationKey($user->activation_key, $user->email, $user->userId);
        }
        else
        {
            $buyer = $user->buyer;
        }

        $user->vendor = 1;
        $user->updatedAt = date('Y-m-d\TH:i:s');

    	// register the new seller
    	$seller = $this->createSeller($user, $params, User::STATUS_NOT_VERIFIED);

        $address = new BillingAddress();
        $address->billingAddressId = RestUtils::generateId();
        $address->address = $params['name'];
        $address->city = $params['city'];
        $address->state = 'NA';
        $address->postCode = '0';
        $address->country = 'Brasil (BRA)';
        $seller->billingAddressId = $address->billingAddressId;

    	// picture
    	$salesman = User::findById($params['salesman']);

    	// credit salesman user with sales token
    	$tx = new Transaction();
    	$tx->transactionId = RestUtils::generateId();
    	$tx->senderId = $user->userId;//'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
    	$tx->recipientId = $salesman->userId;
    	$tx->type = 0;
    	$tx->amount = 1;
    	$tx->fee = 0;
    	$tx->timestamp = date('Y-m-d\TH:i:s');
    	$tx->senderPublicKey = 'aaa';
    	$tx->signature = 'aaa';
    	$tx->tokenId = AssetToken::findByCode('SALE')->tokenId;

    	// credited to salesperson
    	$loyal = new Loyalty();
    	$loyal->loyaltyId = RestUtils::generateId();
    	$loyal->userId = $salesman->userId;
    	$loyal->actionId = ActionReference::findByType('sell')->actionReferenceId;
    	$loyal->ruleId = "Vendas no Local";
    	$loyal->points = 1;
    	$loyal->transactionId = $tx->transactionId;
    	$loyal->status = 'PEN';

    	$rel = new Relationship();
    	$rel->relationshipId = RestUtils::generateId();
    	$rel->dateId = date('Y-m-d\TH:i:s');
    	$rel->sellerId = $seller->sellerId;
    	$rel->buyerId = $salesman->buyer->buyerId;
    	$rel->loyaltyId = $loyal->loyaltyId;

    	$data = array();
    	$data['key'] = $user->activation_key . $user->userId;
    	$data['seller'] = $seller;
    	$data['salesman'] = $salesman->buyer;
    	$data['disclaimer'] = 'Em caso de dúvidas, envie um email para vendas@ondetem-gn.com.br';

    	// send email to seller with confirmation token and link to backend\create
    	$mail = \Yii::$app->mailer->compose('sellerActivationKey-html', [
    		'data' => $data
		])
		    ->setFrom('vendas@ondetem-gn.com.br')
		    ->setTo($seller->email)
		    ->setSubject('OndeTem?! Ativação de Cadastro');

        $res = $this->validateAndSave([$address, $buyer, $user, $seller, $tx, $loyal, $rel]);
        if(isset($res['error']))
        {
            $models['status'] = 500;
            $models['error'] = $res['error'];
            $models['errorLog'] = $res['errorLog'];
        }
        else
        {
            try { $mail->send(); }
            catch(\Swift_SwiftException $exception) {
                $models['mailerror'] = 'Can sent mail due to the following exception '. $exception;
            }
            finally {
                $models['status'] = 200;
                $models['data'] = 'Empresa cadastrada com sucesso';
            }
        }

		echo RestUtils::sendResult($models['status'], $models);
    }

    /**
     * POST /auth/forget-password
     * Receives the email of the user and sends an email with instructions to change the current password
     * 
     */
    public function actionForgotPassword()
    {
        $params = \Yii::$app->request->post();
        $models = array('status'=>500);

        $user = User::findByUsername($params['username']);
        if(is_null($user))
        {
            $models['status'] = AuthToken::USER_MISSING;
            $models['error'] = 'Cadastro não encontrado';
        }
        else
        {
            $data = array();
            //$data['key'] = $user->activation_key . $user->userId;
            $data['disclaimer'] = 'Em caso de dúvidas, envie um email para contato@ondetem-gn.com.br';

            $mail = \Yii::$app->mailer->compose('passwordResetToken-html', [
                'data' => $data
            ])
                ->setFrom('contato@ondetem-gn.com.br')
                ->setTo($user->email)
                ->setSubject('OndeTem?! Recuperação de senha');

            try { $mail->send(); }
            catch(\Swift_SwiftException $exception) {
                $models['error'] = 'Email não enviado: '. $exception;
            }
            finally {
                $models['status'] = 200;
                $models['data'] = 'Siga as intruções contidas no email enviado.';
            }
        }

        echo RestUtils::sendResult($models['status'], $models);
    }

    /**
     * POST /auth/settings
     * Receives the info to change the users preferences
     *
     */
    public function actionSettings()
    {
        $params = \Yii::$app->request->post();
        $models = array('status'=>500);

        if(isset($params['token']) && !empty($params['token']))
        {
            $token = $params['token'];
            list($selector, $authenticator) = explode(':',$token);
            $auth = AuthToken::findBySelector($selector);

            if(is_null($auth))
            {
                // 404
                $models['status'] = AuthToken::TOKEN_MISSING;
            }
            elseif(strtotime($auth->expires) < strtotime(date('Y-m-d H:i:s')))
            {
                // 401
                $models['status'] = AuthToken::TOKEN_EXPIRED;
            }
            else
            {
                if(hash_equals($auth->token, hash('sha256', base64_decode($authenticator))))
                {
                    // logged in
                    $user = User::findById($auth->userId);
                    if(is_null($user))
                    {
                        $models['status'] = AuthToken::USER_MISSING;
                        $models['error'] = 'Usuário não encontrado.';
                    }
                    else
                    {
                        // Alter password
                        if(isset($params['currentPass']) && !empty($params['currentPass']) &&
                           isset($params['newPass']) && isset($params['confirmPass']))
                        {
                            if(!empty($params['newPass']) && !empty($params['confirmPass']))
                            {
                                if($params['confirmPass'] === $params['newPass'])
                                {
                                    if($user->validatePassword($params['currentPass'])) {
                                        $salt = RestUtils::generateSalt();
                                        $user->salt = $salt;
                                        $user->password = User::hashPassword($params['newPass'], $salt);
                                        if($user->save())
                                        {
                                            $models['status'] = 200;
                                            $models['data'] = 'Senha alterada com sucesso';
                                        }
                                    }
                                    else
                                    {
                                        //$models['status'] = AuthToken::USER_WRONG;
                                        $models['error'] = 'Senha incorreta';
                                    }
                                }
                                else
                                    $models['error'] = 'Senha não confere ou em branco.';    
                            }
                            else
                                $models['error'] = 'Senha não confere ou em branco.';

                        }
                        // Alter username
                        elseif(isset($params['username']) && !empty($params['username']))
                        {
                            $models['status'] = 500;
                            $models['error'] = 'Parâmetros não conferem';
                            if(isset($params['buyerId']) && !empty($params['buyerId']))
                            {
                                //$model = Buyer::findById($params['buyerId']);
                                $buyer = $user->buyer;
                                if($buyer->buyerId == $params['buyerId'])
                                {
                                    $buyer->name = $params['username'];
                                    if($buyer->save())
                                    {
                                        $models['status'] = 200;
                                        $models['data'] = 'Nome alterado com sucesso';
                                    }
                                }
                            }
                            elseif(isset($params['sellerId']) && !empty($params['sellerId']))
                            {
                                foreach ($user->sellers as $seller)
                                {
                                    if($seller->sellerId == $params['sellerId'])
                                    {
                                        $seller->name = $params['username'];
                                        if($seller->save())
                                        {
                                            $models['status'] = 200;
                                            $models['data'] = 'Nome alterado com sucesso';
                                        }
                                        break;
                                    }
                                }
                            }
                        }
                        // Alter picture
                        elseif(isset($params['picture']) && !empty($params['picture']))
                        {
                            $models['status'] = 500;
                            $models['error'] = 'Parâmetros não conferem';
                            if(isset($params['buyerId']) && !empty($params['buyerId']))
                            {
                                $buyer = $user->buyer;
                                if($buyer->buyerId == $params['buyerId'])
                                {
                                    if($buyer->picture->pictureId != '4899oxUh7aJvOZFwNir5s')
                                        $pic = $buyer->picture;
                                    else {
                                        $pic = new Picture();
                                        $pic->pictureId = RestUtils::generateId();
                                        $buyer->pictureId = $pic->pictureId;
                                    }

                                    if( substr( $params['picture'], 0, 5 ) === "data:" )
                                    {
                                        $path = '/uploads/userpics/';
                                        $basePath = \Yii::$app->basePath . '/../frontend/web';
                                        $name = \Yii::$app->security->generateRandomString();
                                        
                                        $filename = RestUtils::saveBase64Image($params['picture'], $name, $basePath.$path);

                                        if(isset($params['cover']))
                                            $pic->cover = $path.$filename;
                                        elseif(isset($params['thumbnail']))
                                            $pic->thumbnail = $path.$filename;

                                        if($pic->save())
                                        {
                                            $buyer->save();
                                            $models['status'] = 200;
                                            unset($models['error']);
                                            $models['data'] = 'Foto alterada com sucesso: ' . $name;
                                        }
                                    }
                                }
                            }
                        }
                        else {
                            $models['status'] = AuthToken::USER_MISSING;
                            $models['error'] = 'Usuário não encontrado.';
                        }
                    }
                }
                else
                {
                    $models['status'] = AuthToken::TOKEN_WRONG;
                    $models['error'] = 'Token de autenticação incorreto.';
                }
            }
        }

        echo RestUtils::sendResult($models['status'], $models);
    }

    /**
     * GET /auth/logout/{id}
     *
     * Not used
     * @return null 
     */
    public function actionLogout($id)
    {
        echo RestUtils::generateId();
        $pass = '1234abcd';
        $salt = 'ICrs4QDfroMNZT7xozyFE9l2vmUHlZzRlaISuRhAejoLznDnM6PwhDFyUsmwLCdN';
        $hash = md5($salt . $pass);

        var_dump($hash);
        die();

        return $hashedPass === $this->password;
        return null;
    }

    /**
     * @internal for test purposes
     *
     */
    public function actionMailTest()
    {
    	// $this->redirect(<contoroller>/<action>)
    	$params = \Yii::$app->request->get();
    	$models = array('status'=>500);

    	/*Yii::$app->mailer->compose([
		    'html' => 'contact-html',
		    'text' => 'contact-text',
		]);*/

		$models['disclaimer'] = 'Em caso de dúvidas, envie um email para qualeh@ondetem-gn.com.br';
		$models['message'] = 'Teste de email para contato conosco. Pode ser o <b>código</b> de verificação, ou confimação de cadastro na newsletter. Qualquer coisa vale!';

		$user = array();
		$user['name'] = 'Bruno';

    	$mail = \Yii::$app->mailer->compose('testEmail-html', [
    		'data' => $models,
    		'user' => $user
		])
		    ->setFrom('vendas@ondetem-gn.com.br')
		    ->setTo('luk_gazber@hotmail.com')
		    ->setSubject('Messagem de Teste');

		try
        {
            $mail->send();
        }
        catch(\Swift_SwiftException $exception)
        {
        	$models['error'] = 'Can sent mail due to the following exception '. $exception;
        }
        finally
        {
        	$models['status'] = 200;
        	$models['data'] = 'Email enviado com sucesso';
        }

		echo RestUtils::sendResult($models['status'], $models);
    }

    /**
     * @internal typical override of ActiveController 
     *
     */
    public function behaviors() {
        return
        [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
}
