<?php 
 
namespace api\modules\v1\models;
 
use \yii\db\ActiveRecord;
/**
 * Offer Model
 * This is the model class for table "{{%offer}}".
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class Offer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%offer}}';
    }
 
    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['offerId'];
    }
 
    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['itemId', 'policyId', 'shippingId', 'pricePerUnit', 'description', 'imageHashes', 'keywords', 'condition'], 'required'],
        ];
    }
}