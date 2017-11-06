<?php
namespace NeoPHP\Crypto;


/*
BCMaths:
*/
define('MAX_BASE', 256);
class bcmath_Utils{public static function bcrand($min,$max=false){if(extension_loaded('bcmath')&&USE_EXT=='BCMATH'){if(!$max){$max=$min;$min=0;}return bcadd(bcmul(bcdiv(mt_rand(0,mt_getrandmax()),mt_getrandmax(),strlen($max)),bcsub(bcadd($max,1),$min)),$min);}else{throw new ErrorException("Please install BCMATH");}}public static function bchexdec($hex){if(extension_loaded('bcmath')&&USE_EXT=='BCMATH'){$len=strlen($hex);$dec='';for($i=1;$i<=$len;$i++)$dec=bcadd($dec,bcmul(strval(hexdec($hex[$i-1])),bcpow('16',strval($len-$i))));return $dec;}else{throw new ErrorException("Please install BCMATH");}}public static function bcdechex($dec){if(extension_loaded('bcmath')&&USE_EXT=='BCMATH'){$hex='';$positive=$dec<0?false:true;while($dec){$hex.=dechex(abs(bcmod($dec,'16')));$dec=bcdiv($dec,'16',0);}if($positive)return strrev($hex);for($i=0;$isset($hex[$i]);$i++)$hex[$i]=dechex(15-hexdec($hex[$i]));for($i=0;isset($hex[$i])&&$hex[$i]=='f';$i++)$hex[$i]='0';if(isset($hex[$i]))$hex[$i]=dechex(hexdec($hex[$i])+1);return strrev($hex);}else{throw new ErrorException("Please install BCMATH");}}public static function bcand($x,$y){if(extension_loaded('bcmath')&&USE_EXT=='BCMATH'){return self::_bcbitwise_internal($x,$y,'bcmath_Utils::_bcand');}else{throw new ErrorException("Please install BCMATH");}}public static function bcor($x,$y){if(extension_loaded('bcmath')&&USE_EXT=='BCMATH'){return self::_bcbitwise_internal($x,$y,'self::_bcor');}else{throw new ErrorException("Please install BCMATH");}}public static function bcxor($x,$y){if(extension_loaded('bcmath')&&USE_EXT=='BCMATH'){return self::_bcbitwise_internal($x,$y,'self::_bcxor');}else{throw new ErrorException("Please install BCMATH");}}public static function bcleftshift($num,$shift){if(extension_loaded('bcmath')&&USE_EXT=='BCMATH'){bcscale(0);return bcmul($num,bcpow(2,$shift));}else{throw new ErrorException("Please install BCMATH");}}public static function bcrightshift($num,$shift){if(extension_loaded('bcmath')&&USE_EXT=='BCMATH'){bcscale(0);return bcdiv($num,bcpow(2,$shift));}else{throw new ErrorException("Please install BCMATH");}}public static function _bcand($x,$y){return $x&$y;}public static function _bcor($x,$y){return $x|$y;}public static function _bcxor($x,$y){return $x^$y;}public static function _bcbitwise_internal($x,$y,$op){$bx=self::bc2bin($x);$by=self::bc2bin($y);self::equalbinpad($bx,$by);$ix=0;$ret='';for($ix=0;$ix<strlen($bx);$ix++){$xd=substr($bx,$ix,1);$yd=substr($by,$ix,1);$ret.=call_user_func($op,$xd,$yd);}return self::bin2bc($ret);}public static function bc2bin($num){return self::dec2base($num,MAX_BASE);}public static function bin2bc($num){return self::base2dec($num,MAX_BASE);}public static function dec2base($dec,$base,$digits=FALSE){if(extension_loaded('bcmath')){if($base<2||$base>256)die("Invalid Base: ".$base);bcscale(0);$value="";if(!$digits)$digits=self::digits($base);while($dec>$base-1){$rest=bcmod($dec,$base);$dec=bcdiv($dec,$base);$value=$digits[$rest].$value;}$value=$digits[intval($dec)].$value;return(string)$value;}else{throw new ErrorException("Please install BCMATH");}}public static function base2dec($value,$base,$digits=FALSE){if(extension_loaded('bcmath')){if($base<2||$base>256)die("Invalid Base: ".$base);bcscale(0);if($base<37)$value=strtolower($value);if(!$digits)$digits=self::digits($base);$size=strlen($value);$dec="0";for($loop=0;$loop<$size;$loop++){$element=strpos($digits,$value[$loop]);$power=bcpow($base,$size-$loop-1);$dec=bcadd($dec,bcmul($element,$power));}return(string)$dec;}else{throw new ErrorException("Please install BCMATH");}}public static function digits($base){if($base>64){$digits="";for($loop=0;$loop<256;$loop++){$digits.=chr($loop);}}else{$digits="0123456789abcdefghijklmnopqrstuvwxyz";$digits.="ABCDEFGHIJKLMNOPQRSTUVWXYZ-_";}$digits=substr($digits,0,$base);return(string)$digits;}public static function equalbinpad(&$x,&$y){$xlen=strlen($x);$ylen=strlen($y);$length=max($xlen,$ylen);self::fixedbinpad($x,$length);self::fixedbinpad($y,$length);}public static function fixedbinpad(&$num,$length){$pad='';for($ii=0;$ii<$length-strlen($num);$ii++){$pad.=self::bc2bin('0');}$num=$pad.$num;}}

class Base58 {
	
	//source https://en.bitcoin.it/wiki/Base58Check_encoding
    public static function checkEncode($leadingByte, $bin, $trailingByte = null) {
        $bin = chr($leadingByte) . $bin;
        if ($trailingByte !== null) { $bin .= chr($trailingByte); }
        $checkSum = substr(Hash::SHA256(Hash::SHA256($bin)), 0, 4);
        $bin .= $checkSum;
        $base58 = self::encode(bcmath_Utils::bin2bc($bin));
        for ($i = 0; $i < strlen($bin); $i++) { // for each leading zero-byte, pad base58 with "1"
            if ($bin[$i] != "\x00") { break; }
            $base58 = '1' . $base58;
        }
        return $base58;
    }

	//source https://en.bitcoin.it/wiki/Base58Check_encoding
    public static function encode($num) {
        return bcmath_Utils::dec2base($num, 58, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');
    }
    
    public static function decode($addr) {
	    return bcmath_Utils::base2dec($addr, 58);
    }
		
}	