<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Buyer;
use api\modules\v1\models\User;
use api\modules\v1\models\AuthToken;
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

        $models = array('status'=>1,'email'=>'');
        $models['data'] = 'Done! Check your email';
        RestUtils::setHeader(200);
        echo json_encode($models, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function actionLogout($id)
    {
    	$params = \Yii::$app->request->get();

        $models = array('status'=>1,'count'=>0);
        $models['data'] = 'Logged out ' . date('Y-m-d h:i:s');
        RestUtils::setHeader(200);
        echo json_encode($models, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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
