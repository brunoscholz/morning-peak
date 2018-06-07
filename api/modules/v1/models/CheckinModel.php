<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Buyer;
use common\models\Seller;
use common\models\CheckinFact;
use common\models\ActionReference;

use common\models\AssetToken;
use common\models\Transaction;
use common\models\ActionRelationship;
use api\components\RestUtils;
use yii\base\Model;

class CheckinModel extends Model
{
    private $_buyer;
    private $_seller;
    private $_checkinFact;
    private $_actionReference;
    private $_transaction;
    private $_actionRelationship;

    public function rules()
    {
        return [
            [['Buyer', 'Seller', 'CheckinFact', 'ActionReference', 'Transaction', 'ActionRelationship'], 'required'],
        ];
    }

    public function afterValidate()
    {
        $error = false;
        if(!$this->checkinFact->validate()) {
            $error = true;
        }

        if(!$this->transaction->validate()) {
            $error = true;
        }

        if(!$this->actionRelationship->validate()) {
            $error = true;
        }

        if($error) {
            $this->addError(null);
        }

        parent::afterValidate();
    }

    public function save()
    {
        if(!$this->validate()) {
            return false;
        }

        try {
            $tx = Yii::$app->db->beginTransaction();

            $this->checkinFact->save();

            $usr = User::findByBuyerId($this->buyer->buyerId);

            $this->transaction->recipientId = $usr->userId;
            $this->transaction->tokenId = AssetToken::findByCode('COIN')->tokenId;
            $this->transaction->senderId = 'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
            $this->transaction->type = 'checkin'; // 31

            $multi = RestUtils::GetGifted($this->seller) ? Transaction::GIFTED_MULTIPLIER : 1;
            $this->transaction->amount = Transaction::CHECKIN_AMOUNT * $multi;
            $this->transaction->signature = $usr->validation_key;
            $this->transaction->save();

            $this->actionRelationship->actionReferenceId = $this->actionReference->actionReferenceId;
            $this->actionRelationship->transactionId = $this->transaction->transactionId;
            $this->actionRelationship->socialFactId = $this->checkinFact->checkinFactId;
            $this->actionRelationship->save();

            $tx->commit();
            return true;

        } catch(Exception $e) {
            var_dump($e);
            $tx->rollBack();
            return false;
        }
    }

    public function loadAll($params)
    {
        if(is_null($params) || empty($params))
            return false;

        // load buyer (id)
        if(!empty($params['CheckinFact']['buyerId']) && !is_null($params['CheckinFact']['buyerId']))
            $this->buyer = Buyer::findById($params['CheckinFact']['buyerId']);

        if(!empty($params['CheckinFact']['sellerId']) && !is_null($params['CheckinFact']['sellerId']))
            $this->seller = Seller::findById($params['CheckinFact']['sellerId']);

        // update/edit?
        $this->checkinFact = new CheckinFact(['scenario' => 'register']);
        $this->actionReference = "checkin";

        $this->checkinFact->load($params);
        $this->checkinFact->checkinFactId = RestUtils::generateId();
        $this->checkinFact->actionReferenceId = $this->actionReference->actionReferenceId;
        $this->checkinFact->buyerId = $this->buyer->buyerId;
        $this->checkinFact->sellerId = $this->seller->sellerId;
        //$this->checkinFact->date = date('Y-m-d\Th:i:s');
        $this->checkinFact->status = 'ACT';

        $this->transaction = $this->createTransaction();
        $this->actionRelationship = $this->createRelation();

        return true;
    }

    public function getCheckinFact()
    {
        return $this->_checkinFact;
    }

    public function setCheckinFact($fact)
    {
        if($fact instanceof CheckinFact) {
            $this->_checkinFact = $fact;
        } else if (is_array($fact)) {
            //$this->createSeller($loyal);
        }
    }

    public function getActionReference()
    {
        return $this->_actionReference;
    }

    public function setActionReference($ref)
    {
        return $this->_actionReference = ActionReference::findByType($ref);
    }

    public function getBuyer()
    {
        return $this->_buyer;
    }

    public function setBuyer($buyer)
    {
        if($buyer instanceof Buyer) {
            $this->_buyer = $buyer;
        }
        // error 
    }

    public function getSeller()
    {
        return $this->_seller;
    }

    public function setSeller($seller)
    {
        if($seller instanceof Seller) {
            $this->_seller = $seller;
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
            
        }
    }

    public function getActionRelationship()
    {
        return $this->_actionRelationship;
    }

    public function setActionRelationship($rel)
    {
        if($rel instanceof ActionRelationship) {
            $this->_actionRelationship = $rel;
        } else if (is_array($rel)) {
            
        }
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
            //'Offer' => $this->offer,
            'CheckinFact' => $this->checkinFact,
            'Transaction' => $this->transaction,
            'ActioRelationship' => $this->actionRelationship,
        ];
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
        $rel = new ActionRelationship(['scenario' => 'register']);
        $rel->actionRelationshipId = RestUtils::generateId();
        //$rel->dateId = date('Y-m-d\TH:i:s');

        return $rel;
    }
}
