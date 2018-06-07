<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Offer;
use common\models\VoucherFact;

use common\models\Relationship;
use common\models\ActionReference;

use common\models\AssetToken;
use common\models\Transaction;
use api\components\RestUtils;
use yii\base\Model;

class VoucherModel extends Model
{
    private $_user;
    private $_offer;
    private $_voucherFact;

    private $_actionReference;
    private $_transaction;
    private $_relationship;

    public function rules()
    {
        return [
            [['User', 'Offer', 'VoucherFact', 'Transaction', 'Relationship'], 'required'],
        ];
    }

    public function afterValidate()
    {
        $error = false;
        if(!$this->transaction->validate()) {
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

            $this->transaction->type = $this->actionReference->actionReferenceId;
            $this->transaction->tokenId = AssetToken::findByCode('COIN')->tokenId;
            $this->transaction->senderId = $this->user->userId;
            $this->transaction->recipientId = 'zZN6prD6rzxEhg8sDQz1j';

            $this->transaction->amount = $this->voucherFact->voucher->discount * 1000;
            $this->transaction->signature = $this->user->validation_key;
            $this->transaction->senderPublicKey = $this->user->userId;
            $this->transaction->save();

            $this->relationship->actionReferenceId = $this->actionReference->actionReferenceId;
            $this->relationship->transactionId = $this->transaction->transactionId;
            $this->relationship->save();

            $tx->commit();
            return true;

        } catch(Exception $e) {
            $tx->rollBack();
            return false;
        }
    }

    public function buy($params)
    {
        if(is_null($params) || empty($params))
            return false;

        // if any of the models returns null returns false

        $this->user = User::findByBuyerId($params['VoucherModel']['buyerId']);
        $this->offer = Offer::findById($params['VoucherModel']['offerId']);
        $this->voucherFact = VoucherFact::findById($params['VoucherModel']['voucherFactId']);

        $this->actionReference = 'payVoucher';

        $this->transaction = $this->createTransaction();
        $this->relationship = $this->createRelation();
        // check if voucher expired

        $this->relationship->actionReferenceId = $this->actionReference->actionReferenceId;
        $this->relationship->transactionId = $this->transaction->transactionId;
        $this->relationship->offerId = $this->offer->offerId;
        $this->relationship->sellerId = $this->offer->sellerId;
        $this->relationship->buyerId = $this->user->buyerId;
        $this->relationship->voucherFactId = $this->voucherFact->voucherFactId;

        /*
        var_dump($this->actionReference->actionReferenceId);
        var_dump($this->buyer->buyerId);
        var_dump($this->offer->offerId);
        var_dump($this->seller->sellerId);
        die();
        */
        //$this->scenario = self::BUY_SCENARIO;
        //self::CONSUME_SCENARIO
        return true;
    }

    public function loadAll($params)
    {
        if(is_null($params) || empty($params))
            return false;

        return true;
    }

    public function getActionReference()
    {
        return $this->_actionReference;
    }

    public function setActionReference($ref)
    {
        return $this->_actionReference = ActionReference::findByType($ref);
    }

    public function getVoucherFact()
    {
        return $this->_voucherFact;
    }

    public function setVoucherFact($fact)
    {
        if($fact instanceof VoucherFact) {
            $this->_voucherFact = $fact;
        } else if (is_array($fact)) {
            
        }
    }

    public function getOffer()
    {
        return $this->_offer;
    }

    public function setOffer($offer)
    {
        $this->_offer = $offer;
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
        return $this->_user->buyer;
    }

    public function getSeller()
    {
        return $this->_offer->seller;
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
            
        }
    }

    public function errorList()
    {
        $errorLists = [];
        foreach ($this->getAllModels() as $id => $model) {
            if($model)
                $errorLists[$id] = $model->errors;
        }
        $errorLists['VoucherModel'] = $this->errors;
        return RestUtils::arrayCleaner($errorLists);
    }

    private function getAllModels()
    {
        return [
            //'Offer' => $this->offer,
            'Transaction' => $this->transaction,
            'Relationship' => $this->relationship,
        ];
    }

    public function firstError()
    {
        $ret = $this->errorList();

        while(is_array($ret))
            $ret = reset($ret);

        return $ret;
    }

    protected function createTransaction()
    {
        $tx = new Transaction(['scenario' => 'register']);
        $tx->transactionId = RestUtils::generateId();
        $tx->type = 0;
        $tx->amount = 1;
        $tx->fee = 0;
        $tx->senderPublicKey = 'aaa';
        $tx->signature = 'aaa';
        //$tx->timestamp = date('Y-m-d\TH:i:s');
        //$tx->senderId = 'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
        return $tx;
    }

    protected function createRelation()
    {
        $rel = new Relationship(['scenario' => 'register']);
        $rel->relationshipId = RestUtils::generateId();
        $rel->dateId = strtotime(date('Y-m-d\TH:i:s'));
        /*$rel->voucherFactId = $this->voucherFact->voucherFactId;
        $rel->transactionId = $this->transaction->transactionId;*/

        return $rel;
    }
}
