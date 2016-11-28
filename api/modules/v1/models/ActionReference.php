<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%actionreference}}".
 *
 * @property integer $actionReferenceId
 * @property string $actionGroup
 * @property integer $actionOrder
 * @property string $actionType
 */
class ActionReference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%actionreference}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['actionGroup', 'actionOrder', 'actionType'], 'required'],
            [['actionOrder'], 'integer'],
            [['actionGroup', 'actionType'], 'string', 'max' => 21],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'actionReferenceId' => 'Action Reference ID',
            'actionGroup' => 'Action Group',
            'actionOrder' => 'Action Order',
            'actionType' => 'Action Type',
        ];
    }

    public static function findByType($id)
    {
        return static::find()
            ->where(['like binary', 'actionType', $id])
            ->one();
    }
}
