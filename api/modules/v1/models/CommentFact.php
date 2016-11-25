<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%commentfact}}".
 *
 * @property string $commentFactId
 * @property integer $actionId
 * @property string $reviewFactId
 * @property string $commentId
 */
class CommentFact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%commentfact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commentFactId', 'actionId', 'reviewFactId', 'commentId'], 'required'],
            [['actionId'], 'integer'],
            [['commentFactId', 'reviewFactId', 'commentId'], 'string', 'max' => 21],
            [['commentId'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['commentId' => 'commentId']],
            [['reviewFactId'], 'exist', 'skipOnError' => true, 'targetClass' => Reviewfact::className(), 'targetAttribute' => ['reviewFactId' => 'reviewFactId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'commentFactId' => 'Comment Fact ID',
            'actionId' => 'Action ID',
            'reviewFactId' => 'Review Fact ID',
            'commentId' => 'Comment ID',
        ];
    }

    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['commentId' => 'commentId']);
    }

    public function getReviewFact()
    {
        return null;
    }
}
