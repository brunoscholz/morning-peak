<?php

namespace backend\models\form;

use Yii;
use common\models\Seller;
use common\models\Offer;
use common\models\Item;
use common\models\Picture;
use backend\components\Utils;
use yii\base\Model;
use yii\widgets\ActiveForm;

class OfferForm extends Model
{
	private $_seller;
    private $_offer;
    private $_item;
	private $_picture;

    private $itemPicked = false;

    public function rules()
    {
        return [
            [['Seller', 'Offer', 'Item', 'Picture'], 'required'],
        ];
    }

    public function afterValidate()
    {
    	$error = false;
    	/*if(!$this->seller->validate()) {
    		$error = true;
    	}*/
        if(!$this->offer->validate()) {
            $error = true;
        }
        if(!$this->picture->validate()) {
            $error = true;
        }
        if(!$this->itemPicked) {
            if (!$this->item->validate()) {
                $error = true;
            }
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

        if(!$this->itemPicked) {
            if (!$this->item->save()) {
                $transaction->rollBack();
                return false;
            }
        }

    	$this->offer->pictureId = $this->picture->pictureId;
        $this->offer->itemId = $this->item->itemId;
        //$this->offer->sellerId = $this->seller->sellerId;
        if (!$this->offer->save()) {
            $transaction->rollBack();
            return false;
        }

    	$transaction->commit();
    	return true;
    }

    public function getSeller()
    {
    	return $this->_seller;
    }

    public function setSeller($seller)
    {
        $this->_seller = $seller;
    }

    public function getOffer()
    {
    	return $this->_offer;
    }

    public function setOffer($offer)
    {
        if($offer instanceof Offer) {
            $this->_offer = $offer;
        } else if (is_array($offer)) {
            $this->createOffer($offer);
        }
    }

    public function getItem()
    {
        if($this->_item === null) {
            if($this->offer->isNewRecord) {
                $this->_item = new Item();
                $this->_item->itemId = Utils::generateId();
                $this->_item->loadDefaultValues();
                $this->_item->status = 'ACT';
            } else {
                $this->_item = $this->_offer->item;
            }
        }

        return $this->_item;
    }

    public function setItem($item)
    {
        if(is_array($item)) {
            if(isset($item['categoryId']) && empty($item['categoryId'])) {
                $this->itemPicked = true;
            } else {
                $this->item->setAttributes($item);
            }
        } else if($item instanceof Item) {
            $this->_item = $item;
        }
        //$modelItem->sku = \backend\models\User::getToken(12);
    }

    public function getPicture()
    {
    	if($this->_picture === null) {
    		if($this->offer->isNewRecord) {
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
    		'Offer' => $this->offer,
            'Item' => $this->item,
    		'Picture' => $this->picture,
    	];
    }

    protected function createOffer($params, $status = Offer::STATUS_ACTIVE)
    {
        if($this->_offer->isNewRecord)
            $this->_offer->offerId = Utils::generateId();

        $this->_offer->sellerId = $this->seller;
        $this->_offer->status = $status;
        $this->_offer->setAttributes($params);
    }
}