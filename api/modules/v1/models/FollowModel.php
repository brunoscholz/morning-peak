<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Buyer;
use common\models\Seller;
use common\models\ActionReference;
use common\models\FollowFact;

use common\models\AssetToken;
use common\models\Transaction;
use common\models\ActionRelationship;
use api\components\RestUtils;
use yii\base\Model;

class FollowModel extends Model
{
    private $_author;
    private $_buyer;
    private $_seller;
    private $_actionReference;
    private $_followFact;
    private $_transaction;
    private $_actionRelationship;

    public function rules()
    {
        return [
            [['ActionReference', 'FollowFact', 'Transaction', 'ActionRelationship'], 'required'], //'Offer', 'Buyer', 'Seller',
        ];
    }

    public function afterValidate()
    {
        $error = false;

        if(!$this->followFact->validate()) {
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

            $this->followFact->save();

            $this->transaction->recipientId = $this->author->userId;
            $this->transaction->tokenId = AssetToken::findByCode('COIN')->tokenId;
            $this->transaction->senderId = 'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
            $this->transaction->type = $this->followFact->actionReferenceId;

            $target = (is_null($this->followFact->buyerId) ? $this->seller : $this->buyer);
            $multi = 1;// RestUtils::GetGifted($target) ? Transaction::GIFTED_MULTIPLIER : 1;
            $this->transaction->amount = Transaction::FOLLOW_AMOUNT * $multi;
            $this->transaction->signature = $this->author->validation_key;
            $this->transaction->save();

            $this->actionRelationship->actionReferenceId = $this->followFact->actionReferenceId;
            $this->actionRelationship->transactionId = $this->transaction->transactionId;
            $this->actionRelationship->followFactId = $this->followFact->followFactId;
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
        
        if(!empty($params['FollowFact']['buyerId']) && !is_null($params['FollowFact']['buyerId']))
            $this->buyer = Buyer::findById($params['FollowFact']['buyerId']);

        if(!empty($params['FollowFact']['sellerId']) && !is_null($params['FollowFact']['sellerId']))
            $this->seller = Seller::findById($params['FollowFact']['sellerId']);
        
        if(!empty($params['FollowFact']['userId']) && !is_null($params['FollowFact']['userId']))
            $this->author = User::findByBuyerId($params['FollowFact']['userId']);


        // update/edit?
        $this->followFact = new FollowFact(['scenario' => 'register']);
        $this->actionReference = 'follow';

        $this->followFact->load($params);
        $this->followFact->followFactId = RestUtils::generateId();
        $this->followFact->userId = $this->author->buyer->buyerId;
        $this->followFact->sellerId = (empty($params['FollowFact']['sellerId']) ? null : $this->seller->sellerId);
        $this->followFact->buyerId = (empty($params['FollowFact']['buyerId']) ? null : $this->buyer->buyerId);
        $this->followFact->actionReferenceId = $this->actionReference->actionReferenceId;
        $this->followFact->date = date('Y-m-d\Th:i:s');
        $this->followFact->status = 'ACT';

        $this->transaction = $this->createTransaction();
        $this->actionRelationship = $this->createRelation();

        return true;
    }

    public function getFollowFact()
    {
        return $this->_followFact;
    }

    public function setFollowFact($fact)
    {
        if($fact instanceof FollowFact) {
            $this->_followFact = $fact;
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

    public function getAuthor()
    {
        return $this->_author;
    }

    public function setAuthor($buyer)
    {
        if($buyer instanceof User) {
            $this->_author = $buyer;
        }
        // error 
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
            'FollowFact' => $this->followFact,
            'Transaction' => $this->transaction,
            'ActionRelationship' => $this->actionRelationship,
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
