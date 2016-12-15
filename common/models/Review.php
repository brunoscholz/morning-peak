<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%review}}".
 *
 * @property string $reviewId
 * @property string $title
 * @property string $body
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%review}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['reviewId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reviewId', 'title', 'body'], 'required'],
            [['reviewId', 'body'], 'string'],
            [['title'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reviewId' => 'Review ID',
            'title' => 'Title',
            'body' => 'Body',
        ];
    }
}
