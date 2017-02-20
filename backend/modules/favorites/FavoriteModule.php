<?php

namespace backend\modules\favorites;

use Exception;
use backend\modules\favorites\models\OfferSearch;
use yii\base\Module;
use yii\db\Expression;

class FavoriteModule extends Module
{
    /**
     * @var string The controllers namespace
     */
    public $controllerNamespace = 'backend\modules\favorites\controllers';
    /**
     * @var ReviewFact The review class defined by the application
     */
    public $reviewClass;
    
    /**
     * @inheritdoc
     */
    public function init() {
        /*if (is_callable($this->userId)) {
            $this->userId = call_user_func($this->userId);
        }*/
        parent::init();
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        /*if ($contentContainer instanceof \humhub\modules\space\models\Space) {
            return [
                new permissions\CreateComment()
            ];
        }*/

        return [];
    }
    
    /**
     * @inheritdoc
     */
    public function getNotifications() 
    {
       return [
           //'humhub\modules\comment\notifications\NewComment'
       ];
    }

    /**
     * Checks if given content object can be commented
     * 
     * @param \humhub\modules\content\models\Content $content
     * @return boolean can comment
     */
    public function canComment($content) // \humhub\modules\content\models\Content
    {

        /*if ($content->container instanceof \humhub\modules\space\models\Space) {
            $space = $content->container;
            if (!$space->permissionManager->can(new permissions\CreateComment())) {
                return false;
            }
        }*/

        return true;
    }
}
