<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%date}}".
 *
 * @property integer $dateId
 * @property integer $year
 * @property integer $month
 * @property string $monthName
 * @property integer $day
 * @property string $dayName
 * @property string $date
 * @property string $dateName
 * @property integer $dayInYear
 */
class Date extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%date}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['dateId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'month', 'day', 'date', 'dayInYear'], 'required'],
            [['year', 'month', 'day', 'dayInYear'], 'integer'],
            [['date'], 'safe'],
            [['monthName', 'dayName', 'dateName'], 'string', 'max' => 50],
            [['date'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dateId' => 'Date ID',
            'year' => 'Year',
            'month' => 'Month',
            'monthName' => 'Month Name',
            'day' => 'Day',
            'dayName' => 'Day Name',
            'date' => 'Date',
            'dateName' => 'Date Name',
            'dayInYear' => 'Day In Year',
        ];
    }
}
