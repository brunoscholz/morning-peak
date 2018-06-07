<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Buyer;
use common\models\Offer;
use common\models\ShareFact;
use common\models\ActionReference;

use common\models\AssetToken;
use common\models\Transaction;
use common\models\ActionRelationship;
use api\components\RestUtils;
use yii\base\Model;

class ShareModel extends Model
{
    private $_offer;
    private $_buyer;
    private $_shareFact;
    private $_actionReference;
    private $_transaction;
    private $_actionRelationship;

    public function rules()
    {
        return [
            [['Offer', 'Buyer', 'ShareFact', 'ActionReference', 'Transaction', 'ActionRelationship'], 'required'], //'Offer', 'Buyer', 'Seller',
        ];
    }

    public function afterValidate()
    {
        $error = false;
        if(!$this->shareFact->validate()) {
            $error = true;
        }

        if(!$this->transaction->validate()) {
            $error = true;
        }

        if(!$this->actionRelationship->validate()) {
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

            $this->shareFact->save();

            $usr = User::findByBuyerId($this->buyer->buyerId);

            $this->transaction->recipientId = $usr->userId;
            $this->transaction->tokenId = AssetToken::findByCode('COIN')->tokenId;
            $this->transaction->senderId = 'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
            $this->transaction->type = 'share'; // 7

            $multi = RestUtils::GetGifted($this->offer) ? Transaction::GIFTED_MULTIPLIER : 1;
            $this->transaction->amount = Transaction::SHARE_AMOUNT * $multi;
            $this->transaction->signature = $usr->validation_key;
            $this->transaction->save();

            $this->actionRelationship->actionReferenceId = $this->actionReference->actionReferenceId;
            $this->actionRelationship->transactionId = $this->transaction->transactionId;
            $this->actionRelationship->socialFactId = $this->shareFact->shareFactId;
            $this->actionRelationship->save();

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

        // load buyer (id)
        if(!empty($params['ShareFact']['buyerId']) && !is_null($params['ShareFact']['buyerId']))
            $this->buyer = Buyer::findById($params['ShareFact']['buyerId']);

        if(!empty($params['ShareFact']['offerId']) && !is_null($params['ShareFact']['offerId']))
            $this->offer = Offer::findById($params['ShareFact']['offerId']);

        // update/edit?
        $this->shareFact = new ShareFact(['scenario' => 'register']);
        $this->actionReference = 'share';

        $this->shareFact->load($params);
        $this->shareFact->shareFactId = RestUtils::generateId();
        $this->shareFact->actionReferenceId = $this->actionReference->actionReferenceId;
        $this->shareFact->buyerId = $this->buyer->buyerId;
        $this->shareFact->offerId = $this->offer->offerId;
        //$this->shareFact->date = date('Y-m-d\Th:i:s');
        $this->shareFact->status = 'ACT';

        $this->transaction = $this->createTransaction();
        $this->actionRelationship = $this->createRelation();

        return true;
    }

    public function getShareFact()
    {
        return $this->_shareFact;
    }

    public function setShareFact($fact)
    {
        if($fact instanceof ShareFact) {
            $this->_shareFact = $fact;
        } else if (is_array($fact)) {
            //$this->createSeller($loyal);
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
            'ShareFact' => $this->shareFact,
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
