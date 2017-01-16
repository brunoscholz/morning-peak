<?php

namespace backend\models\form;

use Yii;
use backend\models\User;
use common\models\Buyer;
use common\models\Seller;
use common\models\Picture;
use common\models\BillingAddress;
// use common\models\License;
// use common\models\LicenseType;
use backend\components\Utils;
use yii\base\Model;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

class RegisterForm extends Model
{
	private $_user;
    private $_buyer;
    private $_buyerPicture;
	private $_seller;
	private $_picture;
    private $_billingAddress;

    public $newPassword;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['User', 'Buyer', 'Seller', 'BillingAddress', 'Picture'], 'required'],
            [['newPassword', 'confirmPassword'], 'string', 'min' => 8, 'max' => 60],
            [['newPassword'], 'validatePassword'],
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
        if($this->newPassword != $this->$attribute)
            $this->addError($attribute, 'As senhas não conferem');
    }

    public function afterValidate()
    {
    	$error = false;
    	if(!$this->user->validate()) {
    		$error = true;
    	}
        if(!$this->buyerPicture->validate()) {
            $error = true;
        }
        if(!$this->buyer->validate()) {
            $error = true;
        }
    	if(!$this->seller->validate()) {
    		$error = true;
    	}
        if(!$this->billingAddress->validate()) {
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

            if ($this->buyerPicture->upload()) {
                $this->buyerPicture->imageCover = null;
                $this->buyerPicture->imageThumb = null;
                $this->buyerPicture->save();
            }

            $this->buyer->pictureId = $this->buyerPicture->pictureId;
            $this->buyer->save();

            $this->user->buyerId = $this->buyer->buyerId;
            $this->user->save();

            if ($this->picture->upload()) {
                $this->picture->imageCover = null;
                $this->picture->imageThumb = null;
                $this->picture->save();
            }

            $this->billingAddress->save();

            if((empty($this->user->password) || empty($this->user->salt)) && $this->user->status == 'PEN') {
                $salt = Utils::generateSalt();
                $this->user->salt = $salt;
                $this->user->password = User::hashPassword($this->newPassword, $salt);
                $this->user->status = 'ACT';
                if (!$this->user->save() || empty($this->newPassword)) {
                    throw new Exception("Password is empty", 1);
                }
            }

            $this->seller->pictureId = $this->picture->pictureId;
            $this->seller->billingAddressId = $this->billingAddress->billingAddressId;
            $this->seller->email = $this->user->email;
            $this->seller->userId = $this->user->userId;
            $this->seller->status = User::STATUS_ACTIVE;
            $this->seller->save();

            $tx->commit();
            return true;

        } catch(Exception $e) {
            $tx->rollBack();
            return false;
        }
    }

    public function loadAll($params)
    {
        if(is_null($params) || empty($params))
            return false;

        $this->load($params);
        $this->user->load($params);
        $this->buyer->load($params);
        $this->buyerPicture = $this->createPicture($params['BuyerPicture'], 'BuyerPicture');

        $this->seller->load($params);
        $this->billingAddress->load($params);
        $this->picture->load($params);

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

    public function getSeller()
    {
    	return $this->_seller;
    }

    public function setSeller($seller)
    {
        if($seller instanceof Seller) {
            $this->_seller = $seller;
        } else if (is_array($seller)) {
            $this->_seller = $this->createSeller($seller);
        }
    }

    public function getBillingAddress()
    {
        return $this->_billingAddress;
    }

    public function setBillingAddress($address)
    {
        if(is_array($address)) {
            $this->_billingAddress = $this->createAddress($address);
        } else if($address instanceof BillingAddress) {
            $this->_billingAddress = $address;
        }
    }

    public function getBuyerPicture()
    {
        return $this->_buyerPicture;
    }

    public function setBuyerPicture($picture)
    {
        if(is_array($picture)) {
            $this->_buyerPicture = $this->createPicture($picture);
        } else if($picture instanceof Picture) {
            $this->_buyerPicture = $picture;
        }
    }

    public function getPicture()
    {
        return $this->_picture;
    }

    public function setPicture($picture)
    {
        if(is_array($picture)) {
            $this->_picture = $this->createPicture($picture);
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
            $errorLists[$id] = $model->errors;
        }
        //return implode('', $errorLists);
        return $errorLists;
    }

    private function getAllModels()
    {
    	return [
            'User' => $this->user,
            'Buyer' => $this->buyer,
            'BuyerPicture' => $this->buyerPicture,
    		'Seller' => $this->seller,
    		'Picture' => $this->picture,
            'BillingAddress' => $this->billingAddress,
    	];
    }

    protected function createSeller($params, $status = User::STATUS_ACTIVE)
    {
        if($this->_seller->isNewRecord)
            $this->_seller->sellerId = Utils::generateId();
        //$seller = new Seller();
        //$seller->sellerId = Utils::generateId();
        $seller->name = $params['name'];
        $seller->about = $params['about'];
        $seller->phone = $params['phone'];
        $seller->cellphone = $params['cellphone'];
        $seller->website = $params['website'];
        $seller->createdAt = date('Y-m-d\TH:i:s');
        $seller->status = $status;

        $payList = $params['paymentOptions'];
        $this->seller->paymentOptions = implode(",", $payList);

        $seller->email = $this->user->email;
        //$seller->userId = $this->user->userId;

        //$this->_seller = $seller;
        return $seller;
    }

    protected function createAddress($params)
    {
        $address = new BillingAddress();
        $address->billingAddressId = Utils::generateId();
        $address->address = $params['address'];
        $address->city = $params['city'];
        $address->state = 'NA';
        $address->postCode = '0';
        $address->country = 'Brasil (BRA)';

        return $address;
    }

    protected function createPicture($params, $name="Picture")
    {
        $pic = new Picture();
        $pic->pictureId = Utils::generateId();

        if( substr( $params['imageCover'], 0, 5 ) === "data:" )
        {
            $path = '/uploads/userpics/';
            $basePath = \Yii::$app->basePath . '/../frontend/web';
            $name = \Yii::$app->security->generateRandomString();
            
            $filename = Utils::saveBase64Image($params['imageCover'], $name, $basePath.$path);
            $pic->cover = $path.$filename;
        }
        else
        {
            //$pic->imageCover = UploadedFile::getInstance($params, 'imageCover');
            $pic->imageCover = UploadedFile::getInstanceByName($name.'[imageCover]');
        }

        if( substr( $params['imageThumb'], 0, 5 ) === "data:" )
        {
            $path = '/uploads/userpics/';
            $basePath = \Yii::$app->basePath . '/../frontend/web';
            $name = \Yii::$app->security->generateRandomString();
            
            $filename = Utils::saveBase64Image($params['imageThumb'], $name, $basePath.$path);
            $pic->thumbnail = $path.$filename;
        }
        else
        {
            $pic->imageThumb = UploadedFile::getInstanceByName($name.'[imageThumb]');
        }

        return $pic;
    }
}