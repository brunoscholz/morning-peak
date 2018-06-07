<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace base\library\utils;

use base\AppAdaptor;
/**
 * Class consisting of utility functions related to cookie.
 * 
 * @package base\library\utils
 */
class CookieUtil
{
    /**
     * Get value of the cookie.
     * @param string $cookieName
     * @return Cookie the cookie with the specified name. Null if the named cookie does not exist.
     */
    public static function getValue($cookieName)
    {
        return AppAdaptor::app()->getRequest()->getCookies()->get($cookieName);
    }
    
    /**
     * Remove cookie.
     * @param string $cookieName
     * @return void
     */
    public static function remove($cookieName)
    {
        AppAdaptor::app()->getResponse()->getCookies()->remove($cookieName);
    }
    
    /**
     * Remove all cookies.
     * @return void
     */
    public static function removeAllCookies()
    {
        AppAdaptor::app()->getResponse()->getCookies()->removeAll();
    }
}