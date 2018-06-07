<?php

class ProductDiscount {
   /**
    * Create a NEW discount code and return the instance of
    *
    * @param $code string      the discount code
    * @param $discount float   price adjustment in % (ex:        
    * @param $options array    (optional) an array of options :
    *                            'expire'   => timestamp    (optional)
    *                            'limited'  => int          (optional)
    * @return ProductDiscount                         
    */
   static public function create($code, $discount, $options = NULL);

   /**
    * This essentially validate the code, and return the instance of the
    * discount if the code exists. The method returns null if the discount 
    * is not valid for any reason. If an instance is returned, to apply
    * the discount, one should invoke the "consume()" method of the instance.
    *
    * @param $code string
    *
    * @return ProductDiscount|null
    */
   static public function validate($code);

   private $_code;     // string
   private $_discount; // float
   private $_expire;   // unix timestamp (see time()) or null if unlimited
   private $_count;    // int or null if unlimited

   private function __construct();
   public function getCode();      // return string
   public function getDiscount();  // return float
   public function isLimited();    // return bool; true if $_count || $_expire is not null
   public function getCount();     // returns int; how many of this discount is left or null if unlimited
   public function getExpireDate();// returns int (unix timestamp) or null if unlimited

   public function consume();      // apply this discount now

   public function consumeAll();   // invalidate this discount for future use
}


// validation
/*
SELECT * 
  FROM tbl_voucher
 WHERE code = {$code}                  -- $code = mysql_real_escape_string($code)
   AND (count IS NULL OR count > 0)
   AND (expire IS NULL or expire > NOW())
*/

/*
if (!empty($discountCode)) {
   $discount = ProductDiscount::validate($discountCode);

   if ($discount !== null) {
      $price *= (1 - $discount->getDiscount());
      $discount->consume();
   }
}
*/