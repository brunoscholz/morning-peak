<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Buyer;
use common\models\Seller;
use common\models\Picture;
//use common\models\AuthToken;
use api\components\RestUtils;
use yii\base\Model;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

class UserForm extends Model
{
    const USERNAME_SCENARIO = "updateUsername";
    const PASSWORD_SCENARIO = "updatePassword";
    const PICTURE_SCENARIO = "updatePicture";

	private $_user;
    private $_buyer;
    private $_seller;
	private $_picture;
    private $returnMsg = '';

    public $username;
    public $buyerId;
    public $sellerId;

    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['User', 'Picture', 'newPassword', 'confirmPassword', 'currentPassword', 'username'], 'required'],
            ['buyerId', 'required', 'when' => function($model) {
                return !$model->sellerId && $model->scenario != self::PASSWORD_SCENARIO;
            }],
            [['Seller', 'sellerId'], 'required', 'when' => function($model) {
                return !$model->buyerId && $model->scenario != self::PASSWORD_SCENARIO;
            }],
            [['buyerId'], 'validateBuyer'],
            [['sellerId'], 'validateSeller'],
            [['username'], 'string', 'max' => 21, 'when' => function($model) {
                return !$model->sellerId && $model->scenario != self::PASSWORD_SCENARIO;
            }],
            [['username'], 'string', 'max' => 80, 'when' => function($model) {
                return !$model->buyerId && $model->scenario != self::PASSWORD_SCENARIO;
            }],
            [['currentPassword'], 'validateCurrentPassword'],
            [['newPassword', 'confirmPassword'], 'string', 'min' => 8, 'max' => 60],
            [['newPassword'], 'validatePassword'],
            [['confirmPassword'], 'checkNewPassword'],
        ];
    }

    public function validateBuyer($attribute, $params)
    {
        if($this->user->buyer->buyerId != $this->buyerId)
            $this->addError($attribute, 'Perfil não pertence ao usuário.');
    }

    public function validateSeller($attribute, $params)
    {

        if($this->user->userId != $this->sellerId->userId)
            $this->addError($attribute, 'Empresa não pertence ao usuário.');
    }

    public function validateCurrentPassword($attribute, $params)
    {
        if(!$this->user->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Senha incorreta.');
        }
    }

    public function validatePassword($attribute, $params)
    {
        // ^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d,.;:]).+$
        // (?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
        if (preg_match('/^(?=.*\d).*$/', !$this->$attribute)) {
            $this->addError($attribute, 'Senha inválida.');
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
        /*if(!$this->buyer->validate()) {
            $error = true;
        }*/
        if(!$this->user->validate()) {
            $error = true;
        }
        if(!is_null($this->picture) && !$this->picture->validate()) {
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

            // $this->buyer->save();
            // $this->user->buyerId = $this->buyer->buyerId;
            if ($this->scenario == self::PASSWORD_SCENARIO) {
                $salt = RestUtils::generateSalt();
                $this->user->salt = $salt;
                $this->user->password = User::hashPassword($this->newPassword, $salt);
                $this->user->save();
            }

            if ($this->scenario == self::USERNAME_SCENARIO) {
                if(!$this->buyerId) {
                    $this->seller->save();
                } else {
                    $this->buyer->save();
                }
            }

            if ($this->scenario == self::PICTURE_SCENARIO && $this->picture->upload()) {
                $this->picture->imageCover = null;
                $this->picture->imageThumb = null;
            	$this->picture->save();
            }

        	$tx->commit();

            switch ($this->scenario) {
                case self::PICTURE_SCENARIO:
                    $this->returnMsg = 'Foto salva com sucesso!';
                    break;
                case self::PASSWORD_SCENARIO:
                    $this->returnMsg = 'Senha alterada com sucesso!';
                    break;
                case self::USERNAME_SCENARIO:
                    $this->returnMsg = 'Nome alterado com sucesso!';
                    break;
                default:
                    $this->returnMsg = 'All went well...';
                    break;
            }

        	return true;

        } catch(Exception $e) {
            $tx->rollBack();
            return false;
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::USERNAME_SCENARIO] = ['User', 'username'];
        $scenarios[self::PASSWORD_SCENARIO] = ['User', 'newPassword', 'confirmPassword', 'currentPassword'];
        $scenarios[self::PICTURE_SCENARIO] = ['User', 'Picture'];
        return $scenarios;
    }

    public function loadAll($params)
    {
        $this->load($params);
        /*$this->user->load($params);*/

        if(!empty($this->newPassword) && !is_null($this->newPassword))
            $this->scenario = self::PASSWORD_SCENARIO;
        elseif(!empty($this->username) && !is_null($this->username)) {
            $this->scenario = self::USERNAME_SCENARIO;
            if(!$this->sellerId) {
                $this->buyer = $this->user->buyer;
                $this->buyer->username = $this->username;
            } elseif(!$this->buyerId) {
                $this->seller = $this->createSeller($this->sellerId);
                $this->seller->name = $this->username;
            }
        }
        elseif(isset($params['Picture'])) {
            $this->scenario = self::PICTURE_SCENARIO;
            if(!$this->sellerId) {
                $this->buyer = $this->user->buyer;
                $this->picture = $this->buyer->picture;
            } elseif(!$this->buyerId) {
                $this->seller = $this->createSeller($this->sellerId);
                $this->picture = $this->seller->picture;
            }
            //$this->picture = $params;
            $this->createPicture($params['Picture']);
        }

        // $this->validate();
        // var_dump($this->errorList());
        // die();
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

    public function getSeller()
    {
    	return $this->_seller;
    }

    public function setSeller($seller)
    {
        $this->_seller = $seller;
    }

    public function getPicture()
    {
    	/*if($this->_picture === null) {
            if($this->user->isNewRecord) {
                $this->_picture = new Picture();
                $this->_picture->pictureId = Utils::generateId();
                $this->_picture->loadDefaultValues();
            } else {
                $this->_picture = $this->user->buyer->picture;
            }
        }*/
        return $this->_picture;
    }

    public function setPicture($picture)
    {
    	if(is_array($picture)) {
    		$this->picture->load($picture);
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
        $errorLists['UserForm'] = $this->errors;
        //return implode('', $errorLists);
        //return $errorLists;
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
            //'Buyer' => $this->buyer,
            'User' => $this->user,
    		'Picture' => $this->picture,
            //'Seller' => $this->seller,
    	];
    }

    protected function createSeller($id)
    {
        $seller = Seller::findById($id);
        return $seller;
    }

    protected function createPicture($params)
    {
        // $pic = new Picture();
        // $pic->pictureId = RestUtils::generateId();

        if( substr( $params['imageCover'], 0, 5 ) === "data:" )
        {
            $path = '/uploads/userpics/';
            $basePath = \Yii::$app->basePath . '/../frontend/web';
            $name = \Yii::$app->security->generateRandomString();
            
            $filename = RestUtils::saveBase64Image($params['imageCover'], $name, $basePath.$path);
            $this->picture->cover = $path.$filename;
            $this->picture->imageCover = null;
        }
        else
        {
            //$pic->imageCover = UploadedFile::getInstance($params, 'imageCover');
            $this->picture->imageCover = UploadedFile::getInstanceByName($name.'[imageCover]');
        }

        if( substr( $params['imageThumb'], 0, 5 ) === "data:" )
        {
            $path = '/uploads/userpics/';
            $basePath = \Yii::$app->basePath . '/../frontend/web';
            $name = \Yii::$app->security->generateRandomString();
            
            $filename = RestUtils::saveBase64Image($params['imageThumb'], $name, $basePath.$path);
            $this->picture->thumbnail = $path.$filename;
            $this->picture->imageThumb = null;
        }
        else
        {
            $this->picture->imageThumb = UploadedFile::getInstanceByName($name.'[imageThumb]');
        }
    }
}