<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\db\Query;

/**
 * Offer Controller API
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class OfferController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Offer';

    public function actions()
    {
        $actions = parent::actions();
        // will override return data on the index action
        unset($actions['index']);
        //$actions['index']['prepareDataProvider'] = [new app/models/Post(), 'getAllPost'];
        return $actions;
    }

    public function actionIndex()
    {
        $params=$_REQUEST;
        $filter=array();
        $sort="";
        $page=1;
        $limit=10;

        if(isset($params['limit']))
            $limit=$params['limit'];

        $offset=$limit*($page-1);

        if(isset($params['sort']))
        {
            $sort=$params['sort'];
            if(isset($params['order']))
            {  
                if($params['order']=="false")
                    $sort.=" desc";
                else
                    $sort.=" asc";
            }
        }

        $query=new Query;
        $query->offset($offset)
            ->limit($limit)
            ->from('tbl_offer')
            ->orderBy($sort)
            ->select("*");

        $command = $query->createCommand();
        $models = $command->queryAll();
 
        $totalItems=$query->count();
        $this->setHeader(200);
        echo json_encode(array('status'=>1,'data'=>$models,'count'=>$totalItems)); //,JSON_PRETTY_PRINT
    }

    private function setHeader($status)
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type="application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "OndeTem <ondetem.com.br>");
    }
    
    private function _getStatusCodeMessage($status)
    {
        $codes = Array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function behaviors() {
        return
        [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' =>
            [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => [],
                    'Access-Control-Request-Headers' => [],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 0,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
        ];
    }
}