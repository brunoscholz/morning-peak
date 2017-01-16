<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Buyer;
use common\models\Seller;
use common\models\ActionReference;
use common\models\FollowFact;

use common\models\Loyalty;
use common\models\Transaction;
use common\models\Relationship;
use api\components\RestUtils;
use yii\base\Model;

class ReviewModel extends Model
{
    //private $_user;
    private $_buyer;
    private $_seller;
    private $_actionReference;
    private $_followFact;
    private $_transaction;
    private $_loyalty;
    private $_relationship;

    public function rules()
    {
        return [
            [['ActionReference', 'FollowFact', 'Transaction', 'Loyalty', 'Relationship'], 'required'], //'Offer', 'Buyer', 'Seller',
        ];
    }

    public function afterValidate()
    {
        $error = false;
        /*if(!$this->offer->validate()) {
            $error = true;
        }*/
        if(!$this->actionReference->validate()) {
            $error = true;
        }
        if(!$this->followFact->validate()) {
            $error = true;
        }

        /*if(!$this->seller->validate()) {
            $error = true;
        }
        if(!$this->buyer->validate()) {
            $error = true;
        }*/
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

            //$this->followFact->offerId = $this->offer->offerId;
            $this->followFact->save();

            $this->transaction->recipientId = User::findByBuyerId($this->followFact->userId)->userId;
            $this->transaction->tokenId = AssetToken::findByCode('COIN')->tokenId;
            $this->transaction->senderId = 'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
            $this->transaction->type = $this->followFact->actionReferenceId;
            $this->transaction->amount = Transaction::REVIEW_AMOUNT;
            $this->transaction->signature = User::findByBuyerId($this->followFact->userId)->validation_key;
            $this->transaction->save();

            $this->loyalty->userId = User::findByBuyerId($this->followFact->userId)->userId;
            $this->loyalty->actionId = ActionReference::findByType('follow')->actionReferenceId;
            $this->loyalty->transactionId = $this->transaction->transactionId;
            $this->loyalty->points = $this->transaction->amount;
            $this->loyalty->save();

            $this->relationship->sellerId = $this->followFact->sellerId;
            $this->relationship->buyerId = $this->followFact->buyerId;
            $this->relationship->loyaltyId = $this->loyalty->loyaltyId;
            $this->relationship->save();

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

        // update/edit?
        $this->followFact = new FollowFact(['scenario' => 'register']);
        $this->actionReference = $params['followFact']['action'];

        $this->followFact->load($params);

        $this->followFact->actionReferenceId = $this->actionReference->actionReferenceId;
        $this->followFact->status = 'ACT';

        $this->followFact->sellerId = (empty($this->followFact->sellerId) ? null : $this->followFact->sellerId);
        $this->followFact->buyerId = (empty($this->followFact->buyerId) ? null : $this->followFact->buyerId);

        $this->transaction = $this->createTransaction();
        $this->loyalty = $this->createLoyalty();
        $this->relationship = $this->createRelation();

        /*if(!empty($params['offerId']) && !is_null($params['offerId']))
            $this->offer = Offer::findById($params['offerId']);
        else
            return false;

        if(!empty($params['buyerId']) && !is_null($params['buyerId']))
            $this->buyer = Buyer::findById($params['buyerId']);

        if(!empty($params['sellerId']) && !is_null($params['sellerId']))
            $this->seller = Seller::findById($params['sellerId']);*/

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

    public function getLoyalty()
    {
        return $this->_loyalty;
    }

    public function setLoyalty($loyal)
    {
        if($loyal instanceof Loyalty) {
            $this->_loyalty = $loyal;
        } else if (is_array($loyal)) {
            
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
            'Loyalty' => $this->loyalty,
            'Relationship' => $this->relationship,
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

    protected function createLoyalty()
    {
        $loyal = new Loyalty(['scenario' => 'register']);
        $loyal->loyaltyId = RestUtils::generateId();
        $loyal->ruleId = "Seguir ";
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
