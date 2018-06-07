<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace base\library\utils;

use base\AppAdaptor;
/**
 * DateTime utility methods.
 * @package base\library\utils
 */
class DateTimeUtil
{
    /**
     * Gets formatted date time.
     *
     * @param string $dateTime  Datetime.
     * @param string $dateWidth Date width format.
     * @param string $timeWidth Time width format.
     *
     * @return null
     */
    public static function getFormattedDateTime($dateTime, $format = 'medium')
    {
        if ($dateTime != '0000-00-00 00:00:00' and $dateTime != null)
        {
            if(is_integer($dateTime))
            {
                return AppAdaptor::app()->formatter->asDatetime($dateTime, $format);
            }
            return AppAdaptor::app()->formatter->asDatetime(strtotime($dateTime), $format);
        }
        elseif ($dateTime == null || $dateTime == '0000-00-00 00:00:00')
        {
            return $dateTime = AppAdaptor::t('application', '(not set)');
        }
        return $dateTime;
    }
    
    /**
     * Gets formatted date.
     *
     * @param string $dateTime  Datetime.
     * @param string $dateWidth Date width format.
     * @param string $timeWidth Time width format.
     *
     * @return null
     */
    public static function getFormattedDate($dateTime, $format = 'medium')
    {
        if ($dateTime != '0000-00-00 00:00:00' and $dateTime != null)
        {
            if(is_integer($dateTime))
            {
                return AppAdaptor::app()->formatter->asDate($dateTime, $format);
            }
            return AppAdaptor::app()->formatter->asDate(strtotime($dateTime), $format);
        }
        elseif ($dateTime == null || $dateTime == '0000-00-00 00:00:00')
        {
            return $dateTime = AppAdaptor::t('application', '(not set)');
        }
        return $dateTime;
    }
}
?>