<?php


namespace NeoPHP\Crypto;

/**
 * PKCS #5 v2.0 standard RFC 2898
 */
class Pbkdf2
{
    /**
     * Generate the new key
     *
     * @param string $hash The hash algorithm to be used by HMAC
     * @param string $password The source password/key
     * @param string $salt
     * @param integer $iterations The number of iterations
     * @param integer $length The output size
     * @throws \Exception|\InvalidArgumentException
     * @return string
     */
    public static function calc($hash, $password, $salt, $iterations, $length)
    {
        if (!Hmac::isSupported($hash)) {
            $error = "The hash algorithm $hash is not supported by " . __CLASS__;
            throw new \InvalidArgumentException($error);
        }

        $num = ceil($length / Hmac::getOutputSize($hash, Hmac::OUTPUT_BINARY));
        $result = '';
        for ($block = 1; $block <= $num; $block++) {
            $hmac = hash_hmac($hash, $salt . pack('N', $block), $password, Hmac::OUTPUT_BINARY);
            $mix = $hmac;
            for ($i = 1; $i < $iterations; $i++) {
                $hmac = hash_hmac($hash, $hmac, $password, Hmac::OUTPUT_BINARY);
                $mix ^= $hmac;
            }
            $result .= $mix;
        }
        return substr($result, 0, $length);
    }
}
