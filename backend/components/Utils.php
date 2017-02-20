<?php

namespace backend\components;

use Yii;

class Utils {
	static function dateToString($date)
	{
		$time = strtotime($date);
		return date( 'd/m/Y', $time );
	}

	public static function setFlash($type, $msg)
	{
		/*'error'
        'danger'
        'success'
        'info'
        'warning'*/
        Yii::$app->getSession()->setFlash($type, $msg);
    }

    public static function safePicture($pic, $t)
    {
        $url = $pic->$t;

        if (strpos($url, 'generic-avatar') !== false) {
            $url = \yii\helpers\Url::to('@web/img/') . '/generic-avatar.png';
        }
        elseif (strpos($url, 'generic-cover') !== false) {
            $url = \yii\helpers\Url::to('@web/img/') . '/generic-cover.jpg';
        }

        return $url;
    }

	/**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

	public static function generateId()
    {
        //md5(uniqid($name, true));
        return self::getToken(21);
    }

    public static function generateSalt()
    {
        return self::getToken(64);
    }

    public static function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }

    public static function generateActivationKey()
    {
        return self::getToken(8);
    }

    public static function generateValidationKey($key, $email, $id)
    {
        return  md5($key . $email . $id);
    }

    static function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public static function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[self::crypto_rand_secure(0, $max)];
        }

        return $token;
    }

    public static function truncate($string, $limit)
    {
        $newLimit = min($limit, strlen($string));
        //$adjustedLimit = max(0, $newLimit - strlen($string));

        return substr($string, 0, strrpos($string, ' ', $newLimit - strlen($string)));
    }
}