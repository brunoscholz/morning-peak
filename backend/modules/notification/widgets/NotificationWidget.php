<?php

namespace backend\modules\notification\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class NotificationWidget extends Widget
{
    public $message;
    /**
     * @var array additional options to be passed to the notification library.
     * Please refer to the plugin project page for available options.
     */
    public $clientOptions = [];
    /**
     * @var integer The time to leave the notification shown on screen
     */
    public $delay = 5000;
    /**
     * @var integer the XHR timeout in milliseconds
     */
    public $xhrTimeout = 2000;
    /**
     * @var integer The delay between pulls
     */
    public $pollInterval = 5000;
    /**
     * @var boolean Whether to show already seen notifications
     */
    public $pollSeen = false;
    /**
     * @var array An array of jQuery selector to be updated with the current
     *            notifications count
     */
    public $counters = [];
    
    /**
     * @var string The jQuery selector in which the notifications list should
     *             be rendered
     */
    public $listSelector = null;
    /**
     * @var string The list item HTML template
     */
    public $listItemTemplate = null;
    /**
     * @var string The list item before render callback
     */
    public $listItemBeforeRender = null;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
    }

    public function run()
    {
        return $this->listItemTemplate ? str_replace('{msg}', Html::encode($this->message), $this->listItemTemplate) : Html::encode($this->message);
    }
}