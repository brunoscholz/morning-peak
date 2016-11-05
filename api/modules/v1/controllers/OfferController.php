<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Offer;
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
        $limit=0;
        $select = "*";
        $ftFilters = array();

        // l: limit
        // fo: findOne
        if(isset($params['l']))
        {
            $limit = $params['l'];
            if(isset($params['fo']))
                $limit = 1;
        }

        $offset=$limit*($page-1);

        // f: field set for select
        if(isset($params['f']))
            $select = $params['f'];

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

        // ft: from-to's
        if(isset($params['ft']))
        {
            $ft = (array)json_decode($params['ft']);
            foreach ($ft as $v)
            {
                $ftFilters[$v['field']] = array('from' => $v['low'], 'to' => $v['high']);
            }
        }

        // q: Filter elements
        if(isset($params['q']))
        {
            $filter = (array)json_decode($params['q']);
        }

        $data = Offer::find()
            ->joinwith([
                'seller',
                'policy',
                'shipping',
                'item' => function ($query) {
                    $query->with('category');
                }])
            ->offset($offset)
            ->orderBy($sort)
            ->select($select);

        if($limit > 0)
            $data->limit($limit);

        if(isset($filter['offerId']))
            $data->andFilterWhere(['like', 'offerId', $filter['offerId']]);
        if(isset($filter['itemId']))
            $data->andFilterWhere(['like', 'itemId', $filter['itemId']]);
        if(isset($filter['sellerId']))
            $data->andFilterWhere(['like', 'sellerId', $filter['sellerId']]);
        if(isset($filter['shippingId']))
            $data->andFilterWhere(['like', 'shippingId', $filter['shippingId']]);
        if(isset($filter['condition']))
            $data->andFilterWhere(['like', 'condition', $filter['condition']]);
        if(isset($filter['status']))
            $data->andFilterWhere(['like', 'status', $filter['status']]);

        if(isset($filter['categoryId']))
            $data->andFilterWhere(['like binary', 'tbl_item.categoryId', $filter['categoryId']]);

        foreach ($ftFilters as $key => $value)
        {
            $data->andWhere($key . " >= '". $v['from']."' ");
            $data->andWhere($key . " <= '". $v['to']."'");
        }

        $models = array('status'=>1,'count'=>0);

        // batch query with eager loading
        $offers = array();
        foreach ($data->each() as $offer) {
            $of = $offer->attributes;
            unset($of['itemId'], $of['sellerId'], $of['policyId'], $of['shippingId']);
            $seller = $offer->seller->attributes;
            $policy = $offer->policy->attributes;
            $shipping = $offer->shipping->attributes;
            $cat = $offer->item->category->attributes;
            $item = $offer->item->attributes;
            unset($item['categoryId']);

            $item['category'] = $cat;
            $of['seller'] = $seller;
            $of['policy'] = $policy;
            $of['shipping'] = $shipping;
            $of['item'] = $item;

            $offers[] = $of;
        }

        $models['data'] = $offers;
        $models['count'] = count($offers);

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