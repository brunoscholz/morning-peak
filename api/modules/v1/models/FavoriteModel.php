<?php

namespace api\modules\v1\models;

use Yii;
use common\models\User;
use common\models\Buyer;
use common\models\Offer;
use common\models\ActionReference;
use common\models\FavoriteFact;

use common\models\AssetToken;
use common\models\Transaction;
use common\models\ActionRelationship;
use api\components\RestUtils;
use yii\base\Model;

class FavoriteModel extends Model
{
    //private $_user;
    private $_buyer;
    private $_offer;
    private $_actionReference;
    private $_favoriteFact;
    private $_transaction;
    private $_actionRelationship;

    public function rules()
    {
        return [
            [['ActionReference', 'FavoriteFact', 'Transaction', 'ActionRelationship'], 'required'], //'Offer', 'Buyer', 'Seller',
        ];
    }

    public function afterValidate()
    {
        $error = false;
        if(!$this->favoriteFact->validate()) {
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

            $this->favoriteFact->save();

            $this->transaction->recipientId = User::findByBuyerId($this->favoriteFact->buyerId)->userId;
            $this->transaction->tokenId = AssetToken::findByCode('COIN')->tokenId;
            $this->transaction->senderId = 'zZN6prD6rzxEhg8sDQz1j'; // robot for token creation
            $this->transaction->type = $this->favoriteFact->actionReferenceId;
            
            $multi = 1; // = RestUtils::GetGifted($this->offer) ? Transaction::GIFTED_MULTIPLIER : 1;
            $this->transaction->amount = Transaction::FAVORITE_AMOUNT * $multi;
            $this->transaction->signature = User::findByBuyerId($this->favoriteFact->buyerId)->validation_key;
            $this->transaction->save();

            $this->actionRelationship->actionReferenceId = $this->favoriteFact->actionReferenceId;
            $this->actionRelationship->transactionId = $this->transaction->transactionId;
            $this->actionRelationship->favoriteFactId = $this->favoriteFact->favoriteFactId;
            $this->actionRelationship->save();

            $tx->commit();
            return true;

        } catch(Exception $e) {
            $tx->rollBack();
            return false;
        }
    }

    public function remove()
    {
        if(!$this->validate()) {
            return false;
        }

        try {
            $tx = Yii::$app->db->beginTransaction();

            $this->favoriteFact->save();

            $this->transaction->recipientId = 'zZN6prD6rzxEhg8sDQz1j';
            $this->transaction->tokenId = AssetToken::findByCode('COIN')->tokenId;
            $this->transaction->senderId = User::findByBuyerId($this->favoriteFact->buyerId)->userId;
            $this->transaction->type = $this->favoriteFact->actionReferenceId;
            
            $multi = 1; // = RestUtils::GetGifted($this->offer) ? Transaction::GIFTED_MULTIPLIER : 1;
            $this->transaction->amount = Transaction::FAVORITE_AMOUNT * $multi;
            $this->transaction->signature = User::findByBuyerId($this->favoriteFact->buyerId)->validation_key;
            $this->transaction->save();

            /*$this->actionRelationship->actionReferenceId = $this->favoriteFact->actionReferenceId;
            $this->actionRelationship->transactionId = $this->transaction->transactionId;
            $this->actionRelationship->favoriteFactId = $this->favoriteFact->favoriteFactId;
            $this->actionRelationship->save();*/

            $tx->commit();
            return true;

        } catch(Exception $e) {
            $tx->rollBack();
            return false;
        }
    }

    public function loadAll($params, $scene = 'register')
    {
        if(is_null($params) || empty($params))
            return false;

        if(!empty($params['FavoriteFact']['buyerId']) && !is_null($params['FavoriteFact']['buyerId']))
            $this->buyer = Buyer::findById($params['FavoriteFact']['buyerId']);

        if(!empty($params['FavoriteFact']['offerId']) && !is_null($params['FavoriteFact']['offerId']))
            $this->offer = Offer::findById($params['FavoriteFact']['offerId']);

        // update/edit?
        if ($scene == 'register') {
            $this->favoriteFact = new FavoriteFact(['scenario' => 'register']);
            $this->actionReference = $params['FavoriteFact']['action'];
            unset($params['FavoriteFact']['action']);

            $this->favoriteFact->load($params);
            $this->favoriteFact->favoriteFactId = RestUtils::generateId();
            $this->favoriteFact->offerId = $this->offer->offerId;
            $this->favoriteFact->buyerId = $this->buyer->buyerId;
            $this->favoriteFact->actionReferenceId = $this->actionReference->actionReferenceId;
            $this->favoriteFact->date = date('Y-m-d\Th:i:s');
            $this->favoriteFact->status = 'ACT';

            $this->transaction = $this->createTransaction();
            $this->actionRelationship = $this->createRelation();
        } else {
            if(!$this->favoriteFact)
                return false;
            
            $this->actionReference = $params['FavoriteFact']['action'];

            // change status on favoriteFact for $id
            $this->favoriteFact->actionReferenceId = $this->actionReference->actionReferenceId;
            $this->favoriteFact->date = date('Y-m-d\Th:i:s');
            $this->favoriteFact->status = 'REM';

            $this->actionRelationship = $this->loadRelation();
            $tx = $this->loadTransaction();

            /*var_dump($this->actionRelationship->actionRelationshipId);
            var_dump($tx->transactionId);*/

            // check if transaction is old enough or remove the coins!
            $today = date_create(date('d-m-Y',time()));
            $exp = date('d-m-Y',strtotime($tx->timestamp)); //query result form database
            $date2=date_create($exp);
            $diff=date_diff($today,$date2);

            if ($diff->format("%R%a") < -30) {
                // remove coins
                // create opposite transaction
                $this->transaction = $this->createTransaction();
            } else {
                $this->transaction = $tx;
            }
        }

        return true;
    }

    public function getFavoriteFact()
    {
        return $this->_favoriteFact;
    }

    public function setFavoriteFact($fact)
    {
        if($fact instanceof FavoriteFact) {
            $this->_favoriteFact = $fact;
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

    public function getOffer()
    {
        return $this->_offer;
    }

    public function setOffer($offer)
    {
        if($offer instanceof Offer) {
            $this->_offer = $offer;
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
            'FavoriteFact' => $this->favoriteFact,
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

    protected function loadRelation()
    {
        return ActionRelationship::findByModelId('favoriteFact', $this->_favoriteFact->favoriteFactId, 19);
    }

    protected function loadTransaction()
    {
        return Transaction::findById($this->_actionRelationship->transactionId);
    }
}
