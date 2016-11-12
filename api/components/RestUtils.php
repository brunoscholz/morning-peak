<?php

namespace api\components;

use yii\db\Query;

class RestUtils
{
	public $codes = Array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
    );

	/**
     * set of functions to get attributes from objects and return an array
     * to be converted into a JSON response
     */
	public static function loadQueryIntoVar($data, $scope) {
        $temp = array();
        foreach ($scope as $key => $value) {
            if(is_array($value)) {
                $attr = $data->$key->attributes;
                foreach ($value as $k => $v) {
                    unset($attr[$k]);
                    $attr[$v] = RestUtils::getAttributes($data->$key->$v, $v);
                }
                $temp[$key] = $attr;
            }
            else {
                $temp[$value] = RestUtils::getAttributes($data->$value, $value);
            }
        }
        return $temp;
    }

    // $name was added here for security reasons...
    public static function getAttributes($values, $name) {
		if(!is_array($values)) {
			$values = $values->attributes;
		}

    	if($name === "user") {
			unset($values['password'], $values['passwordStrategy'], $values['resetToken'], $values['salt'], $values['activation_key'], $values['validation_key'], $values['requiresNewPassword'], $values['publicKey']);
    	}

        return $values;
    }

    /**
     * Treats the request and returns a query ready to execute
     */
    public static function getQuery($params, $query)
    {
    	$filter=array();
        $sort="";
        $page=1;
        $limit=0;
        $select = "*";
        $ftFilters = array();

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

        $query->offset($offset)
            ->orderBy($sort)
            ->select($select);

        if($limit > 0)
            $query->limit($limit);

        foreach ($ftFilters as $key => $value)
        {
            $query->andWhere($key . " >= '". $v['from']."' ");
            $query->andWhere($key . " <= '". $v['to']."'");
        }

        // descobrir uma forma de tratar os campos... foreach...
        // item.categoryId

        foreach ($filter as $field => $info) {
        	if(strpos($field, "."))
        		$field = "tbl_" . $field;

        	$query->andFilterWhere([$info['test'], $field, $info['value']]);
        }

        return $query;
    }

    /**
     * Create a reponse header
     */
    public static function setHeader($code)
    {
    	$status = isset($codes[$code]) ? $codes[$code] : '';
        $status_header = 'HTTP/1.1 ' . $code . ' ' . $status;
        $content_type="application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "OndeTem <ondetem.com.br>");
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    }

    /**
     * apparentely not needed in controller behavior
     */
    	/*'corsFilter' =>
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
            ],*/
}

