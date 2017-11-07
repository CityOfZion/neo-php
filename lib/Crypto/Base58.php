<?php
namespace NeoPHP\Crypto;

class Base58 {


    /**
     * checkEncode function.
     * 
     * @access public
     * @static
     * @param mixed $prefix
     * @param mixed $string
     * @param bool $compressed (default: false)
     * @return void
     */
    public static function checkEncode($prefix=false, $string, $compressed=false) {
	    
	    if ($prefix)
	        $string = chr($prefix).$string;
        
        if ($compressed)
        	$string .= chr(0x01);
        
        $string = $string.substr(Hash::SHA256(Hash::SHA256($string)), 0, 4);

        $base58 = self::encode(BcMathUtils::bin2bc($string));
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] != "\x00")
	            break;
	            
            $base58 = '1' . $base58;
        }
        return $base58;
    }

    /**
     * encode function.
     * 
     * @access public
     * @static
     * @param mixed $num
     * @return void
     */
    public static function encode($num,$length=58) {
        return BcMathUtils::dec2base($num, $length, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');
    }
    
    /**
     * decode function.
     * 
     * @access public
     * @static
     * @param mixed $addr
     * @return void
     */
    public static function decode($addr,$length=58) {
	    return \NeoPHP\Utils\BcMathUtils::base2dec($addr, $length);
    }
		
}	