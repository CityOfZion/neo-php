<?php

namespace NeoPHP\Crypto;

class Base58
{

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

    public static function checkEncode($string, $prefix = 128, $compressed = true)
    {

        $string = hex2bin($string);

        if ($prefix)
            $string = chr($prefix) . $string;

        if ($compressed)
            $string .= chr(0x01);

        $string = $string . substr(Hash::SHA256(Hash::SHA256($string)), 0, 4);

        $base58 = self::encode(BcMathUtils::bin2bc($string));
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] != "\x00")
                break;

            $base58 = '1' . $base58;
        }
        return $base58;
    }


    /**
     * checkDecode function.
     *
     * @access public
     * @static
     * @param mixed $string
     * @param mixed $removeLeadingBytes
     * @param int $removeTrailingBytes (default: 4)
     * @return void
     */

    public static function checkDecode($string, $removeLeadingBytes = 1, $removeTrailingBytes = 4, $removeCompression = true)
    {
        $string = bin2hex(BcMathUtils::bc2bin(self::decode($string)));

        //if trailing bytes: Network type
        if ($removeLeadingBytes)
            $string = substr($string, $removeLeadingBytes * 2);

        //if trailing bytes: Checksum
        if ($removeTrailingBytes)
            $string = substr($string, 0, -($removeTrailingBytes * 2));

        //if trailing bytes: compressed byte
        if ($removeCompression)
            $string = substr($string, 0, -2);

        //return string
        return $string;
    }

    /**
     * encode function.
     *
     * @access public
     * @static
     * @param mixed $num
     * @return void
     */

    public static function encode($num, $length = 58)
    {
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

    public static function decode($addr, $length = 58)
    {
        return BcMathUtils::base2dec($addr, $length, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');
    }

}	