<?php
namespace api\components;

use yii\base\InvalidParamException;
use yii\base\Object;
use yii\db\Query;
//use yii\db\ActiveQuery;
use yii\helpers\Json;

/**
 * Class ApiQuery
 */
class ApiQuery extends Object
{
    /**
     * @var array Query parameters
     */
    public $params;

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->set($this->params);
    }
    /**
     * @param null $query
     * @return null|Query
     */
    public function build($query = null)
    {
        if (is_null($query)) {
            $query = new Query();
        } elseif (!($query instanceof Query)) {
            throw new InvalidParamException("Query must be a Query object.");
        }
        if (is_array($this->params)) {
            foreach ($this->params as $field => $info) {
                if(strpos($field, "."))
                    $field = "tbl_" . $field;

                if (isset($info['test']))
                    $query->andFilterWhere([$info['test'], $field, $info['value']]);
                else
                    $query->andFilterWhere(['like', $field, $info]);
            }
        }
        return $query;
    }

    /**
     * @param $params
     * @return $this
     */
    public function set($params)
    {
        if (!empty($params) && !is_array($params)) {
            $params = Json::decode($params);
        }
        $this->params = $params;
        return $this;
    }
}