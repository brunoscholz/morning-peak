<?php
namespace common\components;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
// use yii\rest\ActiveController;
//use yii\base\Controller;

class BaseController extends Controller
{

    /**
     * @inheritdoc
     */
    public function render($view, $params = [])
    {
        if ( Yii::$app->request->getIsAjax() ) {
            Yii::trace('Rendering AJAX');
            return parent::renderAjax($view, $params);
        }
        else {
            return parent::render($view, $params);
        }
    }

    public function renderAjaxContent($content)
    {
        //return $this->getView()->renderAjaxContent($content, $this);
    }

    public function forcePostRequest()
    {
        if (\Yii::$app->request->method != 'POST') {
            print "Invalid method!";
            die();
        }
    }

    /**
     * Create Redirect for AJAX Requests which output goes into HTML content.
     * Is an alternative method to redirect, for ajax responses.
     */
    public function htmlRedirect($url = "")
    {
        /*return $this->renderPartial('@common/views/htmlRedirect.php', array(
            'url' => Url::to($url)
        ));*/
    }

    /**
     * Closes a modal
     */
    public function renderModalClose()
    {
        //return $this->renderPartial('@humhub/views/modalClose.php', array());
    }
}