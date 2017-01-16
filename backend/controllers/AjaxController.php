<?php

namespace backend\controllers;
use backend\components\BaseController;

class AjaxController extends BaseController
{
    public function actionTest()
    {
    	$value = date('h:i:s');
        return $this->render('test', ['time' => $value]);
    }

}

