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

    // adds data attributes and relations to an array
    // the relations are based on the scope sttructure
    public static function loadQueryIntoVar($data) {
        if (is_array($data))
            $arrayMode = TRUE;
        else {
            $data = array($data);
            $arrayMode = FALSE;
        }

        $result = array();
        foreach ($data as $model) {
            if($model === null)
                continue;
            $attributes = $model->getAttributes($model->fields());
            $relations = array();
            foreach (self::getRelations($model) as $key => $related) {
                $relations[$related] = self::loadQueryIntoVar($model->$related);    
            }
            $all = array_merge($attributes, $relations);

            if ($arrayMode)
                array_push($result, $all);
            else
                $result = $all;
        }
        return $result;
    }

    public static function getRelations($class)
    {
      if (is_subclass_of($class, 'yii\db\ActiveRecord')) {

        $tableSchema = $class::getTableSchema();

        $foreignKeys = $tableSchema->foreignKeys;
        $relations = array();

        foreach ($foreignKeys as $key => $value) {
            $splitedNames = explode('_', $value[0]);

            if(array_key_exists("senderId",$value))
                $splitedNames = ['sender'];
            elseif(array_key_exists("recipientId",$value))
                $splitedNames = ['recipient'];
            
            if(array_key_exists("shippingAddressId",$value))
                $splitedNames = ['shippingAddress'];
            if(array_key_exists("billingAddressId",$value))
                $splitedNames = ['billingAddress'];


            foreach ($splitedNames as $name) {
                $relations[$key] = $name; //ucfirst($name);
            }
        }
        return $relations;
      }
    }

    /*public static function loadQueryIntoVar_OLD_AND_NOT_RECURSIVE($data, $scope) {
        $temp = array();
        foreach ($scope as $key => $value) {
            if(is_array($value)) {
                $attr = $data->$key->attributes;
                foreach ($value as $k => $v) {
                    unset($attr[$k]);
                    $attr[$v] = self::getAttributes2($data->$key->$v, $v);
                }
                $temp[$key] = $attr;
            }
            else {
                $temp[$value] = self::getAttributes2($data->$value, $value);
            }
        }
        return $temp;
    }*/

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
            $filter = (array)json_decode($params['q'], true);
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

        	if (isset($info['test']))
        		$query->andFilterWhere([$info['test'], $field, $info['value']]);
        	else
        		$query->andFilterWhere(['like', $field, $info]);
        }

        return $query;
    }

    public static function getSearch($term, $fields, $query)
    {
        foreach ($fields as $field)
            if(strpos($field, "."))
                $field = "tbl_" . $field;

            $query->andFilterWhere(['like', $field, $term]);

        return $query;
    }

    public static function getBalance($id, $token, $query)
    {
        //$query = Loyalty::find();
        $query->joinWith([
            'transaction',
            'token'
        ]);
        $query->where('tbl_transaction.recipientId not like tbl_transaction.senderId');
        $query->andWhere(['like', 'tbl_asset_token.name', $token]);
        $query->select([
            "sum(case when tbl_transaction.senderId LIKE BINARY '".$id."' then tbl_transaction.amount else 0 end) as TotalRed",
            "sum(case when tbl_transaction.recipientId LIKE BINARY '".$id."' then tbl_transaction.amount else 0 end) as TotalBlue"
        ]);
        return $query->createCommand()->queryOne();
    }

     /**
     * @return api\modules\v1\models\AssetToken;
     */
    public static function checkAuth($auth)
    {
        $models = array('status'=>500);

        if(is_null($auth))
        {
            $models['status'] = \api\modules\v1\models\AuthToken::TOKEN_MISSING;
        }
        elseif(strtotime($auth->expires) < strtotime(date('Y-m-d H:i:s')))
        {
            $models['status'] = \api\modules\v1\models\AuthToken::TOKEN_EXPIRED;
        }
        else
        {
            if(self::is_hash_equals($auth->token, hash('sha256', base64_decode($authenticator))))
            {
                $models['status'] = 200;
            }
            else
            {
                $models['status'] = \api\modules\v1\models\AuthToken::TOKEN_WRONG;
            }
        }

        return $models;
    }

    public static function is_hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
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
        header('Access-Control-Allow-Methods: GET,PUT,POST,OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        header('Access-Control-Max-Age: 86400');
    }

    public static function sendResult($code, $models)
    {
        self::setHeader($code);
        return json_encode($models, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function generateId()
    {
        //md5(uniqid($name, true));
        return self::getToken(21);
    }

    public static function generateSalt()
    {
        return self::getToken(64);
    }

    public static function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }

    public static function generateActivationKey()
    {
        return self::getToken(8);
    }

    public static function generateValidationKey($key, $email, $id)
    {
        return  md5($key . $email . $id);
    }

    /*public function validatePassword($password)
    {
        $hashedPass = self::hashPassword($password, $this->salt);
        return $hashedPass === $this->password;
    }

    public static function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }

    public static function generateActivationKey()
    {
        return self::getToken(8);
    }

    public static function generateValidationKey($key, $email, $id)
    {
        return  md5($key . $email . $id);
    }

    public function verifyKeys($activationKey)
    {
        return $this->validation_key === md5($activationKey . $this->email . $this->userId);
    }*/

    static function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public static function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[self::crypto_rand_secure(0, $max)];
        }

        return $token;
    }

    public static function saveBase64Image($base64_image_string, $output_file_without_extentnion, $path_with_end_slash = "")
    {
        /*$splited = explode(',', substr( $base64_image_string , 5 ) , 2);
        $mime=$splited[0];
        $data=$splited[1];*/

        list($mime, $data) = explode(';', $base64_image_string);
        $data = str_replace('base64,', '', $data);
        $data = str_replace(' ','+',$data);
        $data = base64_decode($data);

        $mime_split_without_base64=explode(';', $mime,2);
        $mime_split=explode('/', $mime_split_without_base64[0],2);
        if(count($mime_split)==2)
        {
            $extension=$mime_split[1];
            if($extension=='jpeg') $extension='jpg';
            //if($extension=='javascript')$extension='js';
            //if($extension=='text')$extension='txt';
            $output_file_with_extentnion.=$output_file_without_extentnion.'.'.$extension;
        }
        file_put_contents($path_with_end_slash . $output_file_with_extentnion, $data);
        return $output_file_with_extentnion;
    }
}

