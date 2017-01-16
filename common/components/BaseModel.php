<?php
namespace common\components;

use Yii;

class BaseModel extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function safePicture($t)
    {
    	return '';
    }
}