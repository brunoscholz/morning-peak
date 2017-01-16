<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Buyer;
use common\models\Seller;
use common\models\BillingAddress;
use common\models\Picture;
use common\models\Loyalty;
use common\models\Transaction;
use common\models\Relationship;
use common\models\License;
use common\models\LicenseType;
use common\models\AssetToken;
use common\models\ActionReference;
use api\components\RestUtils;
use yii\base\Model;
use yii\widgets\ActiveForm;

class SellerRegister extends Model
{
	private $_user;
    private $_buyer;
	private $_seller;
    private $_billingAddress;
	private $_picture;
    private $_transaction;
    private $_loyalty;
    private $_relationship;
    private $_license;

    private $_salesman;
    private $_licenseType;

    public $_authenticator;
    public $newPassword;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['User', 'Buyer', 'Seller', 'BillingAddress', 'Picture', 'Transaction', 'License', 'Loyalty', 'Relationship'], 'required'],
            /*[['newPassword', 'confirmPassword'], 'string', 'min' => 8, 'max' => 60],
            [['newPassword'], 'validatePassword'],
            [['confirmPassword'], 'checkNewPassword'],*/
        ];
    }

    public function validatePassword($attribute, $params)
    {
        // ^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d,.;:]).+$
        // (?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
        if (preg_match('/^(?=.*\d).*$/', !$this->attribute)) {
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
        if(!$this->buyer->validate()) {
            $error = true;
        }
        if(!$this->user->validate()) {
            $error = true;
        }
        if(!$this->billingAddress->validate()) {
            $error = true;
        }
        if(!$this->picture->validate()) {
            $error = true;
        }
    	if(!$this->seller->validate()) {
    		$error = true;
    	}
        if(!$this->license->validate()) {
            $error = true;
        }
        if(!$this->transaction->validate()) {
            $error = true;
        }
        if(!$this->loyalty->validate()) {
            $error = true;
        }
        if(!$this->relationship->validate()) {
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

            $this->buyer->save();

            $this->user->buyerId = $this->buyer->buyerId;
            $this->user->save();
            //$this->buyer->link('buyerId', $this->user);

            if ($this->picture->upload()) {
                $this->picture->imageCover = null;
                $this->picture->imageThumb = null;
            	$this->picture->save();
            }

            $this->billingAddress->save();

            $this->seller->pictureId = $this->picture->pictureId;
            $this->seller->billingAddressId = $this->billingAddress->billingAddressId;
            $this->seller->userId = $this->user->userId;
            $this->seller->save();

            $this->license->sellerId = $this->seller->sellerId;
            $this->license->save();

            $this->transaction->recipientId = $this->salesman->userId;
            $this->transaction->tokenId = AssetToken::findByCode('SALE')->tokenId;
            $this->transaction->senderId = $this->user->userId;//'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
            $this->transaction->save();

            $this->loyalty->userId = $this->salesman->userId;
            $this->loyalty->actionId = ActionReference::findByType('sell')->actionReferenceId;
            $this->loyalty->transactionId = $this->transaction->transactionId;
            $this->loyalty->save();

            $this->relationship->sellerId = $this->seller->sellerId;
            $this->relationship->buyerId = $this->salesman->buyer->buyerId;
            $this->relationship->loyaltyId = $this->loyalty->loyaltyId;
            $this->relationship->save();

        	$tx->commit();
        	return true;

        } catch(Exception $e) {
            $tx->rollBack();
            return false;
        }
    }

    public function create($params, $salesman)
    {
        $this->_salesman = $salesman;
        $lt = (isset($params['Seller']['license']) && !empty($params['Seller']['license'])) ? $params['Seller']['license'] : '1';
        $this->_licenseType = LicenseType::findByType('AT' . $lt);

        $user = User::findByUsername(strtolower($params['Seller']['email']));
        if(is_null($user)) {
            //$this->user = $params;
            $this->buyer = $this->createBuyer($params['Seller']['email'], $params['Seller']['name']);
            $this->user = $this->createUser('', User::STATUS_NOT_VERIFIED);
        }
        else {
            $this->user = $user;
            $this->buyer = $user->buyer;
        }

        $this->seller = $this->createSeller($params['Seller']);
        $this->_authenticator = RestUtils::getToken(33);
        $this->seller->activation_key = base64_encode(RestUtils::getToken(9));
        $this->seller->validation_key = hash('sha256', $this->_authenticator);

        $this->license = $this->createLicense($params['Seller']);
        $this->billingAddress = $this->createAddress($params['BillingAddress']);
        $this->picture = $this->createPicture($params['Picture']);

        $this->transaction = $this->createTransaction();
        $this->loyalty = $this->createLoyalty();
        $this->relationship = $this->createRelation();
    }

    public function getUser()
    {
    	return $this->_user;
    }

    public function setUser($user)
    {
        $this->_user = $user;
    }

    public function getSalesman()
    {
        return $this->_salesman;
    }

    public function setSalesman($sl)
    {
        if($sl instanceof User) {
            $this->_salesman = $sl;
        }
    }

    public function getLicenseType()
    {
        return $this->_licenseType;
    }

    public function setLicenseType($lt)
    {
        if($lt instanceof LicenseType) {
            $this->_licenseType = $lt;
        }
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
            $this->billingAddress->setAttributes($address);
        } else if($address instanceof BillingAddress) {
            $this->_billingAddress = $address;
        }
    }

    public function getPicture()
    {
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

    public function getTransaction()
    {
        return $this->_transaction;
    }

    public function setTransaction($tx)
    {
        if($tx instanceof Transaction) {
            $this->_transaction = $tx;
        } else if (is_array($tx)) {
            //$this->createSeller($tx);
        }
    }

    public function getLoyalty()
    {
        return $this->_loyalty;
    }

    public function setLoyalty($loyal)
    {
        if($loyal instanceof Loyalty) {
            $this->_loyalty = $loyal;
        } else if (is_array($loyal)) {
            //$this->createSeller($loyal);
        }
    }

    public function getLicense()
    {
        return $this->_license;
    }

    public function setLicense($lic)
    {
        if($lic instanceof License) {
            $this->_license = $lic;
        } else if (is_array($lic)) {
            //$this->createSeller($lic);
        }
    }

    public function getRelationship()
    {
        return $this->_relationship;
    }

    public function setRelationship($rel)
    {
        if($rel instanceof Relationship) {
            $this->_relationship = $rel;
        } else if (is_array($rel)) {
            //$this->createSeller($rel);
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
            'Buyer' => $this->buyer,
            'User' => $this->user,
    		'Picture' => $this->picture,
            'BillingAddress' => $this->billingAddress,
            'Seller' => $this->seller,
            'License' => $this->license,
            'Transaction' => $this->transaction,
            'Loyalty' => $this->loyalty,
            'Relationship' => $this->relationship,
    	];
    }

    protected function createUser($pass, $status = User::STATUS_ACTIVE)
    {
        $user = new User(['scenario' => 'register']);
        $user->userId = RestUtils::generateId();
        $salt = RestUtils::generateSalt();
        $user->role = User::ROLE_USER;
        $user->vendor = 1;
        $user->visibility = "NOR";
        $user->createdAt = date('Y-m-d\TH:i:s');
        $user->lastLogin = date('Y-m-d\TH:i:s');
        $user->status = $status;
        
        if($pass !== '' && !empty($pass))
        {
            $user->salt = $salt;
            $user->password = User::hashPassword($pass, $salt);
        }

        $user->email = strtolower($this->buyer->email);
        //$user->buyerId = $this->buyer->buyerId;

        //$this->_user = $user;
        return $user;
    }

    protected function createBuyer($email, $name)
    {
        $buyer = new Buyer();
        $buyer->buyerId = RestUtils::generateId();
        $buyer->name = $name;
        $buyer->email = strtolower($email);
        $buyer->createdAt = date('Y-m-d\TH:i:s');
        $buyer->status = "INC";

        //$this->_buyer = $buyer;
        return $buyer;
    }

    protected function createSeller($params, $status = User::STATUS_ACTIVE)
    {
        $seller = new Seller(['scenario' => 'register']);
        $seller->sellerId = RestUtils::generateId();
        $seller->name = $params['name'];
        $seller->about = $params['about'];
        $seller->phone = $params['phone'];
        $seller->cellphone = $params['cellphone'];
        $seller->createdAt = date('Y-m-d\TH:i:s');
        $seller->status = $status;

        $seller->email = $this->user->email;
        //$seller->userId = $this->user->userId;

        //$this->_seller = $seller;
        return $seller;
    }

    protected function createLicense($params, $status = User::STATUS_ACTIVE)
    {
        $license = new License(['scenario' => 'register']);
        $license->licenseId = RestUtils::generateId();
        $license->status = $status;

        $license->licenseTypeId = $this->licenseType->licenseTypeId;
        $license->expiration = date('Y-m-d\TH:i:s', strtotime($this->licenseType->expirationTime));
        //$license->sellerId = $this->seller->sellerId;

        return $license;
    }

    protected function createAddress($params)
    {
        $address = new BillingAddress();
        $address->billingAddressId = RestUtils::generateId();
        $address->address = $params['address'];
        $address->city = $params['city'];
        $address->state = 'NA';
        $address->postCode = '0';
        $address->country = 'Brasil (BRA)';

        return $address;
    }

    protected function createPicture($params)
    {
        $pic = new Picture();
        $pic->pictureId = RestUtils::generateId();

        if( substr( $params['cover'], 0, 5 ) === "data:" )
        {
            $path = '/uploads/userpics/';
            $basePath = \Yii::$app->basePath . '/../frontend/web';
            $name = \Yii::$app->security->generateRandomString();
            
            $filename = RestUtils::saveBase64Image($params['cover'], $name, $basePath.$path);
            $pic->cover = $path.$filename;
        }

        if( substr( $params['thumbnail'], 0, 5 ) === "data:" )
        {
            $path = '/uploads/userpics/';
            $basePath = \Yii::$app->basePath . '/../frontend/web';
            $name = \Yii::$app->security->generateRandomString();
            
            $filename = RestUtils::saveBase64Image($params['thumbnail'], $name, $basePath.$path);
            $pic->thumbnail = $path.$filename;
        }

        return $pic;
    }

    protected function createTransaction()
    {
        $tx = new Transaction(['scenario' => 'register']);
        $tx->transactionId = RestUtils::generateId();
        $tx->type = 0;
        $tx->amount = 1;
        $tx->fee = 0;
        //$tx->timestamp = date('Y-m-d\TH:i:s');
        $tx->senderPublicKey = 'aaa';
        $tx->signature = 'aaa';

        //$tx->senderId = $this->user->userId;//'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation

        return $tx;
    }

    protected function createLoyalty()
    {
        $loyal = new Loyalty(['scenario' => 'register']);
        $loyal->loyaltyId = RestUtils::generateId();
        $loyal->ruleId = "Vendas no Local";
        $loyal->points = 1;
        $loyal->status = 'PEN';

        return $loyal;
    }

    protected function createRelation()
    {
        $rel = new Relationship(['scenario' => 'register']);
        $rel->relationshipId = RestUtils::generateId();
        $rel->dateId = date('Y-m-d\TH:i:s');

        return $rel;
    }
}