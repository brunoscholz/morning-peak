<?php

namespace backend\components;

use Yii;
use common\models\Offer;
use common\models\FollowFact;
use machour\yii2\notifications\models\Notification as BaseNotification;

class Notification extends BaseNotification
{

    /**
     * A new follower notification
     */
    const KEY_NEW_FOLLOWER = 'new_follower';
    /**
     * An offer has been traded by coins
     */
    const KEY_OFFER_TRADED = 'offer_traded';
    /**
     * No disk space left !
     */
    const KEY_NO_DISK_SPACE = 'no_disk_space';

    /**
     * @var array Holds all usable notifications
     */
    public static $keys = [
        self::KEY_NEW_FOLLOWER,
        self::KEY_OFFER_TRADED,
        self::KEY_NO_DISK_SPACE,
    ];

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        switch ($this->key) {
            case self::KEY_OFFER_TRADED:
                return 'Uma oferta foi trocada!'; //Yii::t('app', 'Meeting reminder');

            case self::KEY_NEW_FOLLOWER:
                return 'Você tem um novo seguidor'; //Yii::t('app', 'You got a new message');

            case self::KEY_NO_DISK_SPACE:
                return Yii::t('app', 'No disk space left');
        }
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        switch ($this->key) {
            case self::KEY_OFFER_TRADED:
                $offer = Offer::findOne($this->keyId);
                return Yii::t('app', 'Alguém trocou {item}', [
                    'item' => $offer->item->title
                ]);

            case self::KEY_NEW_FOLLOWER:
                $flw = FollowFact::findOne($this->keyId);
                /*Yii::t('app', '{customer} sent you a message', [
                    'customer' => $meeting->customer->name
                ]);*/
                return $flw->user->buyer->name . ' começou a seguir você..';

            case self::KEY_NO_DISK_SPACE:
                // We don't have a key_id here
                return 'Please buy more space immediately';
        }
    }

    /**
     * @inheritdoc
     */
    public function getRoute()
    {
        switch ($this->key) {
            case self::KEY_OFFER_TRADED:
                return ['/offer/view', 'id' => $this->keyId];

            case self::KEY_NEW_FOLLOWER:
                return ['/buyer/view', 'id' => $this->keyId];

            case self::KEY_NO_DISK_SPACE:
                return 'https://aws.amazon.com/';
        };
    }

}