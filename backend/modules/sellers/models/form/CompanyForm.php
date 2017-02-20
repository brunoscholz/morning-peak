<?php

namespace backend\modules\sellers\models\form;

use Yii;
use common\models\Seller;
use common\models\Picture;
use common\models\BillingAddress;
use backend\models\User;
use backend\components\Utils;
use yii\base\Model;
use yii\widgets\ActiveForm;

class CompanyForm extends Model
{
	private $_user;
	private $_seller;
    private $_billingAddress;
	private $_picture;

    public function rules()
    {
        return [
            [['User', 'Seller', 'BillingAddress', 'Picture'], 'required'],
        ];
    }

    public function afterValidate()
    {
    	$error = false;
    	/*if(!$this->user->validate()) {
    		$error = true;
    	}*/
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
    	$transaction = Yii::$app->db->beginTransaction();
        if ($this->picture->upload()) {
            $this->picture->imageCover = null;
            $this->picture->imageThumb = null;
        	if(!$this->picture->save()) {
        		$transaction->rollBack();
        		return false;
        	}
        }

        if (!$this->billingAddress->save()) {
            $transaction->rollBack();
            return false;
        }

    	$this->seller->pictureId = $this->picture->pictureId;
        $this->seller->billingAddressId = $this->billingAddress->billingAddressId;
        $this->seller->email = $this->user->email;
        $this->seller->userId = $this->user->userId;
        if (!$this->seller->save()) {
            $transaction->rollBack();
            return false;
        }

    	$transaction->commit();
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

    public function getSeller()
    {
    	return $this->_seller;
    }

    public function setSeller($seller)
    {
        if($seller instanceof Seller) {
            $this->_seller = $seller;
        } else if (is_array($seller)) {
            $this->createSeller($seller);
        }
    }

    public function getBillingAddress()
    {
        if($this->_billingAddress === null) {
            if($this->seller->isNewRecord) {
                $this->_billingAddress = new BillingAddress();
                $this->_billingAddress->billingAddressId = Utils::generateId();
                $this->_billingAddress->loadDefaultValues();
            } else {
                $this->_billingAddress = $this->_seller->billingAddress;
            }
        }

        return $this->_billingAddress;
    }

    public function setBillingAddress($address)
    {
        if(is_array($address)) {
            $this->billingAddress->setAttributes($address);
        } else if($address instanceof BillingAddress) {
            $this->_billingAddress = $address;
        }
    }

    public function getPicture()
    {
    	if($this->_picture === null) {
    		if($this->seller->isNewRecord) {
    			$this->_picture = new Picture();
                $this->_picture->pictureId = Utils::generateId();
    			$this->_picture->loadDefaultValues();
    		} else {
    			$this->_picture = $this->_seller->picture;
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

    private function getAllModels()
    {
    	return [
    		'Seller' => $this->seller,
            'BillingAddress' => $this->billingAddress,
    		'Picture' => $this->picture,
    	];
    }

    protected function createSeller($params, $status = User::STATUS_ACTIVE)
    {
        if($this->_seller->isNewRecord)
            $this->_seller->sellerId = Utils::generateId();

        $this->_seller->status = $status;
        $this->_seller->setAttributes($params);
        $payList = $params['paymentOptions'];
        $this->seller->paymentOptions = implode(",", $payList);
    }
}