<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Offer;
use common\models\Buyer;
use common\models\Seller;
use common\models\ActionReference;
use common\models\ReviewFact;
use common\models\Review;

use common\models\AssetToken;
use common\models\Loyalty;
use common\models\Transaction;
use common\models\ActionRelationship;
use api\components\RestUtils;
use yii\base\Model;

class ReviewModel extends Model
{
    private $_offer;
    private $_buyer;
    private $_seller;
    private $_actionReference;
    private $_reviewFact;
    private $_review;
    private $_transaction;
    private $_loyalty;
    private $_actionRelationship;

    public function rules()
    {
        return [
            [['ActionReference', 'ReviewFact', 'Review', 'Transaction', 'Loyalty', 'ActionRelationship'], 'required'], //'Offer', 'Buyer', 'Seller',
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
        if(!$this->reviewFact->validate()) {
            $error = true;
        }
        if(!$this->review->validate()) {
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

            //$this->offer->save();
            $this->review->save();

            //$this->reviewFact->offerId = $this->offer->offerId;
            $this->reviewFact->reviewId = $this->review->reviewId;
            $this->reviewFact->save();

            $this->transaction->recipientId = User::findByBuyerId($this->reviewFact->buyerId)->userId;
            $this->transaction->tokenId = AssetToken::findByCode('COIN')->tokenId;
            $this->transaction->senderId = 'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
            $this->transaction->type = $this->reviewFact->actionReferenceId;
            $this->transaction->amount = Transaction::REVIEW_AMOUNT;
            $this->transaction->signature = User::findByBuyerId($this->reviewFact->buyerId)->validation_key;
            $this->transaction->save();

            $this->loyalty->userId = User::findByBuyerId($this->reviewFact->buyerId)->userId;
            $this->loyalty->actionReferenceId = ActionReference::findByType('addReview')->actionReferenceId;
            $this->loyalty->transactionId = $this->transaction->transactionId;
            $this->loyalty->points = $this->transaction->amount;
            $this->loyalty->save();

            $this->actionRelationship->actionReferenceId = $this->reviewFact->actionReferenceId;
            $this->actionRelationship->reviewFactId = $this->reviewFact->reviewFactId;
            $this->actionRelationship->loyaltyId = $this->loyalty->loyaltyId;
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

        // update/edit?
        $this->reviewFact = new ReviewFact(['scenario' => 'register']);
        $this->review = new Review();
        $this->actionReference = $params['ReviewFact']['action'];

        $this->reviewFact->load($params);
        $this->review->load($params);

        $this->review->reviewId = RestUtils::generateId();

        $this->reviewFact->reviewFactId = RestUtils::generateId();
        $this->reviewFact->actionReferenceId = $this->actionReference->actionReferenceId;
        $this->reviewFact->sellerId = (empty($this->reviewFact->sellerId) ? null : $this->reviewFact->sellerId);
        $this->reviewFact->date = date('Y-m-d\Th:i:s');
        $this->reviewFact->status = 'ACT';

        $this->transaction = $this->createTransaction();
        $this->loyalty = $this->createLoyalty();
        $this->actionRelationship = $this->createRelation();

        //$this->offer = Offer::findById($this->reviewFact->offerId);

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

    public function getOffer()
    {
        return $this->_offer;
    }

    public function setOffer($offer)
    {
        $this->_offer = $offer;
    }

    public function getReviewFact()
    {
        return $this->_reviewFact;
    }

    public function setReviewFact($fact)
    {
        if($fact instanceof ReviewFact) {
            $this->_reviewFact = $fact;
        } else if (is_array($fact)) {
            //$this->createSeller($loyal);
        }
    }

    public function getReview()
    {
        return $this->_review;
    }

    public function setReview($rev)
    {
        if($rev instanceof Review) {
            $this->_review = $rev;
        } else if (is_array($rev)) {
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
            'ReviewFact' => $this->reviewFact,
            'Review' => $this->review,
            'Transaction' => $this->transaction,
            'Loyalty' => $this->loyalty,
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

    protected function createLoyalty()
    {
        $loyal = new Loyalty(['scenario' => 'register']);
        $loyal->loyaltyId = RestUtils::generateId();
        $loyal->ruleId = "Avaliação de Produto";
        $loyal->points = 1;
        $loyal->status = 'PEN';

        return $loyal;
    }

    protected function createRelation()
    {
        $rel = new ActionRelationship(['scenario' => 'register']);
        $rel->actionRelationshipId = RestUtils::generateId();
        //$rel->dateId = date('Y-m-d\TH:i:s');

        return $rel;
    }
}
