<?php

namespace NeoPHP\Crypto;

class KeyPair
{

    /**
     * getPublicKeyFromPrivateKey function.
     *
     * @access public
     * @static
     * @param mixed $privateKey
     * @return void
     */

    public static function getPublicKeyFromPrivateKey($privateKey)
    {

        //setup curve for: secp256k1
        $secp256k1 = new CurveFp('115792089210356248762697446949407573530086143415290314195533631308867097853951',
            '115792089210356248762697446949407573530086143415290314195533631308867097853948',
            '41058363725152142129326129780047268409114441015993725554835256314039467401291');
        $secp256k1_G = new Point($secp256k1,
            '48439561293906451759052585252797914202762949526041747995844080717082404635286',
            '36134250956749795798585127919587881956611106672985015071877198253568414405109',
            '115792089210356248762697446949407573529996955224135760342422259061068512044369'
        );

        $point = Point::mul(BcmathUtils::bin2bc("\x00" . hex2bin($privateKey)), $secp256k1_G);

        $pubBinStr = "\x04" . str_pad(BcmathUtils::bc2bin($point->getX()), 32, "\x00", STR_PAD_LEFT)
            . str_pad(BcmathUtils::bc2bin($point->getY()), 32, "\x00", STR_PAD_LEFT);

        $pubBinStrCompressed = (intval(substr($point->getY(), -1, 1)) % 2 == 0 ? "\x02" : "\x03")
            . str_pad(BcmathUtils::bc2bin($point->getX()), 32, "\x00", STR_PAD_LEFT);

        return bin2hex($pubBinStrCompressed);

    }

    /**
     * getAddressFromPublicKey function.
     *
     * @access public
     * @static
     * @param mixed $publicKeyHex
     * @return void
     */

    public static function getAddressFromPublicKey($publicKeyHex)
    {

        //appending i donno why
        $publicKey = '21' . $publicKeyHex . 'ac';

        //convert the hex to binary
        $publicKey = hex2bin($publicKey);

        //SHA256 to raw format (binary) and then the RIPEMD160 to hex
        $ripHash = bin2hex(Hash::RIPEMD160(Hash::SHA256($publicKey)));

        //add the ADDRESS VERSION (improvement of explanation please)
        $ripHash = 17 . $ripHash;

        //Convert hex hash to bin. Then hash to SHA256 twice. Last one returns a hex again (first binary)
        $shaOutput = Hash::SHA256(Hash::SHA256(hex2bin($ripHash)), false);

        //we need the first 4 bits. So first 8 chars
        $shaChecksum = substr($shaOutput, 0, 8);

        //merge all together
        $stringToBeEncoded = $ripHash . $shaChecksum;

        //base58 wants decimal stuff, not hex
        return Base58::encode(BcmathUtils::bchexdec($stringToBeEncoded));

    }


    /**
     * getAddressFromPrivateKey function.
     *
     * @access public
     * @static
     * @param mixed $privateKey
     * @return void
     */

    public static function getAddressFromPrivateKey($privateKey)
    {
        $publicKeyHex = self::getPublicKeyFromPrivateKey($privateKey);
        return self::getAddressFromPublicKey($publicKeyHex);

    }

    /**
     * createPrivateKey function.
     *
     * @access private
     * @return void
     */

    static public function createPrivateKey()
    {
        return openssl_random_pseudo_bytes(32);
    }

    /**
     * createPrivateKey function.
     *
     * @access public
     * @static
     * @return void
     */
    
    static public function createPrivateKeyHex()
    {
        return bin2hex(self::createPrivateKey());
    }

}
