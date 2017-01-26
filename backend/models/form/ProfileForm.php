<?php

namespace backend\models\form;

use Yii;
use common\models\Buyer;
use common\models\Picture;
use common\models\User as UserModel;
use backend\models\User;
use backend\components\Utils;
use yii\base\Model;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

class ProfileForm extends Model
{
    const USER_SCENARIO = 'formUser';
    const PASS_SCENARIO = 'formPass';
    const PICTURE_SCENARIO = 'formPicture';

	private $_user;
	private $_buyer;
    private $_picture;
    private $commonError;

    public $username;

    public $checkPassword;
    public $newPassword;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['User', 'Buyer', 'Picture'], 'required'],
            [['checkPassword', 'newPassword', 'confirmPassword'], 'string', 'min' => 8, 'max' => 60],
            [['checkPassword'], 'validatePassword'],
            [['confirmPassword'], 'checkNewPassword'],
            [['username'], 'string', 'max' => 21],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::USER_SCENARIO] = ['User', 'Buyer', 'username'];
        $scenarios[self::PASS_SCENARIO] = ['User', 'newPassword', 'confirmPassword', 'checkPassword'];
        $scenarios[self::PICTURE_SCENARIO] = ['User', 'Buyer', 'Picture'];
        return $scenarios;
    }

    public function validatePassword($attribute, $params)
    {
        if(!$this->user->validatePassword($this->$attribute) && !is_null($this->$attribute)) {
            //$this->addError($attribute, 'Senha incorreta.');
        }
    }

    public function checkNewPassword($attribute, $params)
    {
        if($this->newPassword != $this->$attribute)
            $this->addError($attribute, 'As senhas não conferem');
    }

    public function afterValidate()
    {
    	$error = false;
    	if(!$this->user->validate()) {
    		$error = true;
    	}
    	if(!$this->buyer->validate()) {
    		$error = true;
    	}
    	if(!$this->picture->validate()) {
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

            if ($this->scenario == self::PICTURE_SCENARIO && $this->picture->upload()) {
                $this->picture->imageCover = null;
                $this->picture->imageThumb = null;
                $this->picture->save();
                $this->buyer->pictureId = $this->picture->pictureId;
            }

            // if new
            //$this->buyer->email = $this->user->email;
            //$this->user->buyerId = $this->buyer->buyerId;
            $this->buyer->save();

            if($this->user->role !== $this->user->getOldAttribute('role')) {
                $auth = \Yii::$app->authManager;
                $role = $auth->getRole('user');
                switch ($this->user->role) {
                    case 'administrator':
                        $role = $auth->getRole('admin');
                        break;
                    case 'salesman':
                        $role = $auth->getRole('salesman');
                        break;
                    default:
                        if(count($this->user->sellers) > 0)
                            $role = $auth->getRole('vendor');
                        break;
                }

                $auth->revokeAll($this->user->userId);
                $auth->assign($role, $this->user->userId);
            }

            if ($this->scenario == self::PASS_SCENARIO) {
                $salt = RestUtils::generateSalt();
                $this->user->salt = $salt;
                $this->user->password = User::hashPassword($this->newPassword, $salt);
            }

            $this->user->email = strtolower($this->user->email);
            $this->user->save();

            $tx->commit();
            return true;

        } catch(Exception $e) {
            $tx->rollBack();
            $this->addError('commonError', $e);
            return false;
        }
    }

    public function loadAll($params)
    {
        $this->load($params);

        if($this->scenario == self::USER_SCENARIO) {
            $this->buyer = $this->user->buyer;
            $this->user->load($params);
            $this->buyer->load($params);
        } elseif($this->scenario == self::PASS_SCENARIO) {
            $this->buyer = $this->user->buyer;
            $this->user->load($params);
            $this->buyer->load($params);
        } elseif($this->scenario == self::PICTURE_SCENARIO) {
            $this->buyer = $this->user->buyer;
            $this->picture = $this->buyer->picture;
            $this->picture->load($params);
            $this->picture->imageCover = UploadedFile::getInstance($this->picture, 'imageCover');
            $this->picture->imageThumb = UploadedFile::getInstance($this->picture, 'imageThumb');
        }
    }

    public function fromExisting($user)
    {

    }

    public function getUser()
    {
    	return $this->_user;
    }

    public function setUser($user)
    {
    	if($user instanceof User) {
    		$this->_user = $user;
    	} else if (is_array($user)) {
    		// model load?
    		$this->createUser($user);
    	}
    }

    public function getBuyer()
    {
    	if($this->_buyer === null) {
    		if($this->user->isNewRecord) {
    			$this->_buyer = new Buyer();
                $this->_buyer->buyerId = Utils::generateId();
    			$this->_buyer->loadDefaultValues();
    		} else {
    			$this->_buyer = $this->_user->buyer;
    		}
    	}

    	return $this->_buyer;
    }

    public function setBuyer($buyer)
    {
    	if(is_array($buyer)) {
    		$this->buyer->setAttributes($buyer);
    	} else if($buyer instanceof Buyer) {
    		$this->_buyer = $buyer;
    	}
    }

    public function getPicture()
    {
    	if($this->_picture === null) {
    		if($this->buyer->isNewRecord) {
    			$this->_picture = new Picture();
                $this->_picture->pictureId = Utils::generateId();
    			$this->_picture->loadDefaultValues();
    		} else {
    			$this->_picture = $this->_buyer->picture;
    		}
    	}

    	return $this->_picture;
    }

    public function setPicture($picture)
    {
    	if(is_array($picture)) {
    		$this->picture->setAttributes($picture);
    	} else if($picture instanceof Picture) {
    		$this->_picture = $picture;
    	}
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
        $errorLists['ProfileForm'] = $this->errors;
        return \api\components\RestUtils::arrayCleaner($errorLists);
    }

    public function firstError()
    {
        $ret = $this->errorList();

        while(is_array($ret))
            $ret = reset($ret);

        return $ret;
    }

    private function getAllModels()
    {
    	return [
    		'User' => $this->user,
    		'Buyer' => $this->buyer,
    		'Picture' => $this->picture,
    	];
    }

    public function createUser($params, $status = User::STATUS_ACTIVE)
    {
        if($this->_user->isNewRecord)
            $this->_user->userId = Utils::generateId();
        $this->_user->role = User::ROLE_USER;
        $this->_user->vendor = 0;
        $this->_user->visibility = "NOR";
        $this->_user->status = $status;
        $this->_user->setAttributes($params);
        
        if(isset($params['password']) && !empty($params['password'])) {
            $salt = Utils::generateSalt();
            $this->_user->salt = $salt;
            $this->_user->password = User::hashPassword($pass, $salt);
        } else {
            $this->_user->activation_key = Utils::generateActivationKey();
            $this->_user->validation_key = Utils::generateValidationKey($this->_user->activation_key, $this->_user->email, $this->_user->userId);
        }
    }

    /*
    protected function createBuyer($params)
    {
        if(!empty($params)) {
            $buyer = new Buyer();
            $buyer->buyerId = Utils::generateId();
            if($buyer->load($params) && $buyer->validate())
            {
                $buyer->status = User::STATUS_ACTIVE;
                return $buyer;
            }
        }

        return null;
    }
    */
}