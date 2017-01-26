<?php
namespace api\modules\v1\controllers;

use yii\swiftmailer\Mailer;
use yii\db\Query;
use common\models\Buyer;
use common\models\Seller;
use common\models\User;
use common\models\AuthToken;
use common\models\SocialAccount;
use common\models\AssetToken;
use common\models\Transaction;
use common\models\Loyalty;
use common\models\Relationship;
use common\models\License;
use common\models\LicenseType;
use common\models\ActionReference;
use common\models\BillingAddress;
use api\modules\v1\models\SellerRegister;
use api\modules\v1\models\AuthModel;
use api\modules\v1\models\UserForm;
use common\models\Picture;
use api\components\RestUtils;

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
    protected $APP_VERSION = 'v1.4.4';

    /**
     * @internal typical override of ActiveController 
     *
     */
    public $modelClass = 'common\models\User';

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

        $auth = new AuthModel();
        if(isset($params['AuthModel']['socialId']) || isset($params['AuthModel']['token']) || isset($params['AuthModel']['username']))
        {
            $auth->signin($params);
            if($auth->validateAuth() && $auth->authenticate()) {
                $models['status'] = 200;
                $models['data'] = [$this->fetchUser($auth->user)];
                $models['token'] = $auth->token;

            } else {
                $models['status'] = AuthToken::TOKEN_WRONG;
                $models['error'] = $auth->firstError();
            }
        }
        else
        {
            $models['error'] = 'Parâmetros inválidos!';
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

        $auth = new AuthModel();
        if(isset($params['AuthModel']['username']) || isset($params['AuthModel']['password']) || isset($params['AuthModel']['socialId']))
        {
            $auth->signup($params);

            if($auth->register()) {
                $models['status'] = 200;
                $models['data'] = [$this->fetchUser($auth->user)];
                $models['token'] = $auth->token;
                //$auth->sendEmail();

            } else {
                $models['status'] = AuthToken::TOKEN_WRONG;
                $models['error'] = $auth->firstError();
            }
        }
        else
        {
            $models['error'] = 'Parâmetros inválidos!';
        }

        echo RestUtils::sendResult($models['status'], $models);
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

        $register = new SellerRegister();

        $salesman = User::findById($params['salesman']);
        $register->create($params, $salesman);

    	$data = array();
    	//$data['key'] = $user->activation_key . $user->userId;
        $data['key'] = $register->seller->activation_key.base64_encode($register->_authenticator);
    	$data['seller'] = $register->seller;
    	$data['salesman'] = $salesman->buyer;
    	$data['disclaimer'] = 'Em caso de dúvidas, envie um email para vendas@ondetem-gn.com.br';

        // send email to seller with confirmation token and link to backend\create
        $mail = \Yii::$app->mailer->compose('sellerActivationKey-html', [
            'data' => $data
        ])
            ->setFrom('vendas@ondetem-gn.com.br')
            ->setTo($register->seller->email)
            ->setSubject('Onde tem? Ativação de Cadastro');

        if($register->save())
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
        else
        {
            $models['status'] = 500;
            $models['error'] = $register->firstError();
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
            $authenticator = RestUtils::getToken(33);
            $user->resetKey = base64_encode(RestUtils::getToken(9));
            $user->resetToken = hash('sha256', $authenticator);
            $user->save();
            //$user->requiresNewPassword = 1;
            $data['username'] = $user->name;
            $data['key'] = $user->resetKey.base64_encode($authenticator);
            $data['disclaimer'] = 'Em caso de dúvidas, envie um email para contato@ondetem-gn.com.br';

            $mail = \Yii::$app->mailer->compose('passwordResetToken-html', [
                'data' => $data
            ])
                ->setFrom('contato@ondetem-gn.com.br')
                ->setTo($user->email)
                ->setSubject('Onde tem? - Recuperação de senha');

            try { $mail->send(); }
            catch(\Swift_SwiftException $exception) {
                $models['error'] = 'Email não enviado: '. $exception;
            }
            finally {
                $models['status'] = 200;
                $models['data'] = 'Siga as instruções contidas no email enviado.';
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

        $auth = new AuthModel();
        if(isset($params['token']) && !empty($params['token'])) {
            if($auth->validateToken($params['token'])) {
                // logged in
                $userModel = new UserForm();
                $userModel->user = $auth->user;
                $userModel->loadAll($params);

                if($userModel->save()) {
                    $models['status'] = 200;
                    $models['data'] = $userModel->resultMessage();
                }
                else {
                    $models['errors'] = $userModel->firstError();
                }
            } else {
                // error
                $models['status'] = AuthToken::TOKEN_WRONG;
                $models['error'] = 'Token de autenticação incorreto.';
            }
        } else {
            $models['status'] = AuthToken::TOKEN_MISSING;
            $models['error'] = 'Token de autenticação incorreto.';
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
        die();
        $pass = '1234abcd';
        $salt = 'ICrs4QDfroMNZT7xozyFE9l2vmUHlZzRlaISuRhAejoLznDnM6PwhDFyUsmwLCdN';
        $hash = md5($salt . $pass);
        //var_dump($hash);

        $genAuthenticator = RestUtils::getToken(33);
        $genSelector = base64_encode(RestUtils::getToken(9));
        $genToken = hash('sha256', $genAuthenticator);
        
        $publicToken = $genSelector.base64_encode($genAuthenticator);

        var_dump($genAuthenticator);
        var_dump($genSelector);
        var_dump($genToken);
        var_dump($publicToken);

        //list($selector, $authenticator) = explode(':',$publicToken);
        $selector = substr($publicToken, 0, 12);
        $authenticator = substr($publicToken, 12);

        var_dump($selector);
        var_dump($authenticator);

        if($genToken === hash('sha256', base64_decode($authenticator)))
            var_dump(true);
        else
            var_dump(false);

        //$auth = AuthToken::findBySelector($selector);



        return $hashedPass === $this->password;
        return null;
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
