<?php

namespace NeoPHP\Crypto;

/**
 * taken from: https://en.bitcoin.it/wiki/Wallet_import_format
 *
 * Class WIF
 * @package NeoPHP\Crypto
 */
class WIF
{

    /**
     * getWifForPrivateKey function.
     *
     * @access public
     * @static
     * @param mixed $privateKey
     * @return mixed
     */

    public static function getWifForPrivateKey($privateKey)
    {
        return Base58::checkEncode($privateKey);
    }


    /**
     * getPrivateKeyFromWif function.
     *
     * @access public
     * @static
     * @param mixed $wif
     * @return mixed
     */

    public static function getPrivateKeyFromWif($wif)
    {
        return Base58::checkDecode($wif);
    }
    
    /**
     * getScriptHashFromAddress function.
     *
     * @access public
     * @param mixed $address
     * @return mixed
     */
    public static function getScriptHashFromAddress($address)
    {
        $hexString = Base58::checkDecode($address, 1, 3);
        return \NeoPHP\Tools\StringTools::reverseHex($hexString);
    }

    /**
     * validateWif function.
     *
     * @access public
     * @static
     * @param mixed $wif
     * @return string
     */

    public static function validateWif($wif)
    {
        //validate the WIF
        $uncompressedWif = BCMathUtils::bc2bin(Base58::decode($wif));

        //filter out last 4 bytes
        $uncompressedWifNoChecksum = substr($uncompressedWif, 0, -4);

        // check if the last 4 bytes
        // with the first four of the uncompressed wif,
        // with SHA256 twice
        $hashed = Hash::SHA256(Hash::SHA256($uncompressedWifNoChecksum));
        return (substr($uncompressedWif, -4) == substr($hashed, 0, 4));
    }
}
