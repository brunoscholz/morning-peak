<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@base', dirname(dirname(__DIR__)) . '/base');

Yii::$classMap['yii\base\ArrayableTrait'] = dirname(dirname(__DIR__)) . '/base/ArrayableTrait.php';
Yii::$classMap['yii\helpers\ArrayHelper'] = dirname(dirname(__DIR__)) . '/base/ArrayHelper.php';