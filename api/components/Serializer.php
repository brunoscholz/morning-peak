<?php
namespace api\components;

use Yii;
use yii\base\Arrayable;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * Class Serializer
 */
class Serializer extends Object
{
    /**
     * Serializes a set of models.
     * @param array $models
     * @return array the array representation of the models
     */
    public function serializeModelsOLD(array $models)
    {
        list ($fields, $expand) = $this->getRequestedFields();
        foreach ($models as $i => $model) {
            if ($model instanceof Arrayable) {
                $models[$i] = $model->toArray($fields, $expand);
            } elseif (is_array($model)) {
                $models[$i] = ArrayHelper::toArray($model);
            }
        }
        return $models;
    }

    public static function serializeModels($data) {
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
                $relations[$related] = self::serializeModels($model->$related);    
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

    /**
     * @return array the names of the requested fields. The first element is an array
     * representing the list of default fields requested, while the second element is
     * an array of the extra fields requested in addition to the default fields.
     * @see Model::fields()
     * @see Model::extraFields()
     */
    protected function getRequestedFields()
    {
        $fields = Yii::$app->request->get('fields');
        $expand = Yii::$app->request->get('expand');
        return [
            preg_split('/\s*,\s*/', $fields, -1, PREG_SPLIT_NO_EMPTY),
            preg_split('/\s*,\s*/', $expand, -1, PREG_SPLIT_NO_EMPTY),
        ];
    }
}