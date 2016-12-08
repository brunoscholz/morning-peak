<?php

namespace backend\components;

use Yii;

class Utils {
	static function dateToString($date)
	{
		$time = strtotime($date);
		return date( 'd/m/Y', $time );
	}
}