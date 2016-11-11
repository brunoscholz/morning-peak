<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Offer;
use api\modules\v1\models\Seller;
use api\modules\v1\models\Buyer;

//use api\modules\v1\models\Geography;

class SearchController extends \yii\rest\ActiveController
{
	public $modelClass = 'api\modules\v1\models\Offer';

	public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        unset($actions['index'], $actions['create']);
        return $actions;
    }

    public function actionIndex()
    {
        $params=$_REQUEST;
        $term="";

        $sort="";
        $page=1;
        $limit=0;
        $selectFrom = array('offers', 'categories', 'sellers', 'buyers');

        if(isset($params['l']))
        {
            $limit = $params['l'];
        }

        $offset=$limit*($page-1);

        // f: searchFor... Selects the different models to include
        if(isset($params['f']))
            $selectFrom = (array)json_decode($params['f']);

        // s: sortOrder
        if(isset($params['s']))
        {
            $so = (array)json_decode($params['s']);
            $sort = $so['field'];

            if(isset($so['order']))
            {
                if($so['order'] == "false" || $so['order'] == "desc")
                    $sort.=" desc";
                else
                    $sort.=" asc";
            }
        }

        // q: Filter elements
        if(isset($params['q']) && !empty($params['q']))
        {
            $term = $params['q'];
            // $term = explode(" ", $params['q']);
        }

        $models = array('status'=>1,'count'=>0);

        /*$offers = array();
        if (array_key_exists("offers", $selectFrom))
        {*/
        	$offers = Offer::find()
	            ->joinwith([
	                'policy',
	                'shipping',
	                'seller',
	                'item',
	                //'reviews'
	            ])
	            ->offset($offset)
	            ->orderBy($sort)
	            ->select("*");

            $offers->orFilterWhere(['like', 'tbl_offer.description', $term]);
            $offers->orFilterWhere(['like', 'tbl_offer.keywords', $term]);
            $offers->orFilterWhere(['like', 'tbl_item.title', $term]);
            $offers->orFilterWhere(['like', 'tbl_item.description', $term]);
            $offers->orFilterWhere(['like', 'tbl_item.keywords', $term]);
            //$$offers->andFilterWhere(['like', 'status', "ATV"]);
        // }

        //print_r($offers->createCommand()->rawSql);
        //var_dump($offers->all());

        $modelsArray = array();
        foreach ($offers->each() as $model)
        {
        	//var_dump($model);
            $of = $model->attributes;
            unset($of['itemId'], $of['sellerId'], $of['policyId'], $of['shippingId']);
            $seller = $model->seller->attributes;
            $policy = $model->policy->attributes;
            $shipping = $model->shipping->attributes;
            $cat = $model->item->category->attributes;
            $item = $model->item->attributes;
            unset($item['categoryId']);
            $item['category'] = $cat;
            
            $reviews = array();
            foreach($model->reviews as $rev)
            {
                $reviews[] = $rev->attributes;
            }

            $of['seller'] = $seller;
            $of['policy'] = $policy;
            $of['shipping'] = $shipping;
            $of['item'] = $item;
            $of['reviews'] = $reviews;

            $modelsArray[] = $of;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        $this->setHeader(200);
        echo json_encode($models, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        die();

    }

    private function setHeader($status)
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type="application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "OndeTem <ondetem.com.br>");
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
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
