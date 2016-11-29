<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $commentId
 * @property string $message
 * @property string $parent
 * @property string $status
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['commentId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commentId', 'message', 'status'], 'required'],
            [['commentId', 'parent'], 'string', 'max' => 21],
            [['message'], 'string', 'max' => 140],
            [['status'], 'string', 'max' => 3],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['parent' => 'commentId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'commentId' => 'Comment ID',
            'message' => 'Message',
            'parent' => 'Parent',
            'status' => 'Status',
        ];
    }
}
