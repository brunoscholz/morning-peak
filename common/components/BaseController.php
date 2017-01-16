<?php
namespace common\components;

use Yii;
use yii\web\Controller;
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
}