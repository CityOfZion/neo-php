<?php
namespace NeoPHP\Tools;

class StringTools
{
	
	/**
	 * string2hex function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $string
	 * @return void
	 */
	public static function string2hex($string){
	    $hex='';
	    for ($i=0; $i < strlen($string); $i++){
	        $hex .= dechex(ord($string[$i]));
	    }
	    return $hex;
	}
	
	/**
	 * hex2string function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $hex
	 * @return void
	 */
	public static function hex2string($hex){
	    $string='';
	    for ($i=0; $i < strlen($hex)-1; $i+=2){
	        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
	    }
	    return $string;
	}
	
	public static function uInt16($i, $endianness=false) {
        $f = is_int($i) ? "pack" : "unpack";

        if ($endianness === true) {  // big-endian
            $i = $f("n", $i);
        }
        else if ($endianness === false) {  // little-endian
            $i = $f("v", $i);
        }
        else if ($endianness === null) {  // machine byte order
            $i = $f("S", $i);
        }

        return is_array($i) ? $i[1] : $i;
    }
    
    
    /**
     * reverseHex function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function reverseHex($hexString) {
	   return bin2hex(strrev(hex2bin($hexString)));
    }
    

        
        	
}	