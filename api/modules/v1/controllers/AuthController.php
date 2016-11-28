<?php

namespace api\modules\v1\controllers;

use yii\swiftmailer\Mailer;
use yii\db\Query;
use api\modules\v1\models\Buyer;
use api\modules\v1\models\Seller;
use api\modules\v1\models\User;
use api\modules\v1\models\AuthToken;
use api\modules\v1\models\AssetToken;
use api\modules\v1\models\Transaction;
use api\components\RestUtils;

class AuthController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\Buyer';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    // zZN6prD6rzxEhg8sDQz1j
    public function actionSignin()
    {
    	$params = \Yii::$app->request->post();
    	$models = array('status'=>500);
    	//NkhEQ0RSd2dV:bWx1NzlEUHNnMUc1Tk5pa3hDTGlqcE1JNzd3RHE5NnFh

    	// remember me auto login
    	if(isset($params['token']) && !empty($params['token']))
    	{
    		list($selector, $authenticator) = explode(':', $params['token']);

    		$auth = AuthToken::findBySelector($selector);

    		if(is_null($auth))
    		{
    			// 404
    			$models['status'] = AuthToken::TOKEN_MISSING;
    		}
	   		elseif(strtotime($auth->expires) < strtotime(date('Y-m-d\TH:i:s')))
    		{
    			// 401
    			$models['status'] = AuthToken::TOKEN_EXPIRED;
    		}
    		else
    		{
	    		if(hash_equals($auth->token, hash('sha256', base64_decode($authenticator))))
	    		{
	    			// logged in
	    			$models['status'] = 200;
	    			// change last login in user table
	    			$user = User::findById($auth->userId);
	    			$user->lastLogin = date('Y-m-d\TH:i:s');
	    			$user->save();
	    			$models['data'] = [RestUtils::loadQueryIntoVar($user)];
	    		}
	    		else
	    		{
	    			$models['status'] = AuthToken::TOKEN_WRONG;
	    		}
    		}

    	}
    	elseif(isset($params['username']) && isset($params['password']))
		{
			$user = User::findByUsername($params['username']);
			if(is_null($user))
			{
				$models['status'] = AuthToken::USER_MISSING;
			}
			elseif($user->validatePassword($params['password']))
			{
				// if remember me...
				$auth = AuthToken::findByUser($user->userId);
				if(is_null($auth))
				{
					$models['firstLogin'] = 1;
				}
				
				$authModel = new AuthToken();
				$authModel->authTokenId = RestUtils::generateId();
				$authModel->userId = $user->userId;
				$authModel->selector = base64_encode(RestUtils::getToken(9));
				$authenticator = RestUtils::getToken(33);
				$authModel->token = hash('sha256', $authenticator);
				//$authModel->expires = date('Y-m-d\TH:i:s', time() + 864000); //(7 * 24 * 60 * 60)
				$authModel->expires = date('Y-m-d\TH:i:s', strtotime('+6 months'));

				$authModel->save();

				// change last login in user table
				$user->lastLogin = date('Y-m-d\TH:i:s');
    			$user->save();

				$models['status'] = 200;
				$models['data'] = [RestUtils::loadQueryIntoVar($user)];
				$models['token'] = $authModel->selector.':'.base64_encode($authenticator);
			}
			else
			{
				$models['status'] = AuthToken::USER_WRONG;
			}
		}

        //$models['data'] = 'Logged in ' . date('Y-m-d h:i:s');
        echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionSignup()
    {
    	$params = \Yii::$app->request->post();
    	$models = array('status'=>500);

    	// facebook, twitter, g+

    	$user = new User();
    	$user->userId = RestUtils::generateId();
    	$user->email = $params['username'];
    	$salt = RestUtils::generateSalt();
    	$user->salt = $salt;
    	$user->password = User::hashPassword($params['password'], $salt);
    	$user->status = User::STATUS_ACTIVE;

    	$user->role = User::ROLE_USER;
    	$user->vendor = 0;
    	$user->visibility = "NOR";

    	$buyer = new Buyer();
    	$buyer->buyerId = RestUtils::generateId();
    	$buyer->userId = $user->userId;
    	$buyer->name = $params['name'];
    	$buyer->email = $user->email;
    	$buyer->status = "INC";


        //$models['data'] = 'Done! Check your email';
        $models['data'] = [$user, $buyer];
        var_dump($models);
        die();

        //echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionSocialConnect()
    {
    	$params = \Yii::$app->request->post();
    	$models = array('status'=>500);

    	if(isset($params['facebook'])){}
    }

    public function actionSellerRegister()
    {
 	   	$params = \Yii::$app->request->post();
    	$models = array('status'=>500);

    	$user = new User();
    	$user->userId = RestUtils::generateId();
    	$user->email = $params['email'];
    	$user->role = User::ROLE_USER;
    	$user->vendor = 1;
    	$user->visibility = "NOR";
    	$user->activation_key = RestUtils::generateActivationKey();
        $user->validation_key = RestUtils::generateValidationKey($user->activation_key, $user->email, $user->userId);
    	$user->status = User::STATUS_NOT_VERIFIED;

    	$buyer = new Buyer();
    	$buyer->buyerId = RestUtils::generateId();
    	$buyer->userId = $user->userId;
    	$buyer->name = $params['name'];
    	$buyer->email = $user->email;
    	$buyer->status = "INC";

    	// register the new seller
    	$seller = new Seller();
    	$seller->sellerId = RestUtils::generateId();
    	$seller->userId = $user->userId;
    	$seller->name = $params['name'];
    	$seller->email = $user->email;
    	//$seller->phone = $params{'phone'};
    	//$seller->website = $params['website'];
    	$seller->hours = $params['hours'];
    	$seller->createdAt = date('Y-m-d\TH:i:s');
    	$seller->status = Seller::STATUS_NOT_VERIFIED;

    	// picture

    	$salesman = Buyer::findByUserId($params['salesman']);

    	// credit salesman user with sales token
    	$tx = new Transaction();
    	$tx->transactionId = RestUtils::generateId();
    	$tx->senderId = 'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
    	$tx->recipientId = $salesman->userId;
    	$tx->type = 0;
    	$tx->amount = 1;
    	$tx->fee = 0;
    	$tx->timestamp = date('Y-m-d\TH:i:s');
    	$tx->senderPublicKey = 'aaa';
    	$tx->signature = 'aaa';
    	$tx->tokenId = AssetToken::findByCode('COIN')->tokenId;
    	$tx->save();

    	var_dump($tx);
    	die();

    	$data = array();
    	$data['key'] = $user->activation_key;
    	$data['seller'] = $seller;
    	$data['salesman'] = $salesman;
    	$data['disclaimer'] = 'Em caso de dúvidas, envie um email para vendas@ondetem-gn.com.br';

    	// send email to seller with confirmation token and link to backend\create
    	$mail = \Yii::$app->mailer->compose('sellerActivationKey-html', [
    		'data' => $data
		])
		    ->setFrom('vendas@ondetem.tk')
		    ->setTo($user->email)
		    ->setSubject('OndeTem?! Ativação de Cadastro');

		/*try { $mail->send(); }
        catch(\Swift_SwiftException $exception) {
        	$models['error'] = 'Can sent mail due to the following exception '. $exception;
        }
        finally {
        	$models['status'] = 200;
        	$models['data'] = 'Empresa cadastrada com sucesso';
        }*/

        $models['user'] = $user;
    	$models['buyer'] = $buyer;
    	$models['seller'] = $seller;
    	$models['tx'] = $tx;

		echo RestUtils::sendResult($models['status'], $models);	
    }

    public function actionLogout($id)
    {}

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
		    ->setFrom('vendas@ondetem.tk')
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

    public function actionForgetPassword() {}

    public function actionSettings() {}

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
