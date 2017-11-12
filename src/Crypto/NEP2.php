<?php

namespace NeoPHP\Crypto;

use NeoPHP\NeoPHP;

class NEP2
{

    const NEP_HEADER = '0142';
    const NEP_FLAG = 'e0';

    static public function encrypt($privateKeyHex, $keyPhrase)
    {
        //get the address from the private key:
        $address = KeyPair::getAddressFromPrivateKey($privateKeyHex);
        
		//hash the address
        $addressCheck = substr(Hash::SHA256(Hash::SHA256($address),false),0,8);
        
        //get derived data
        $derived = bin2hex(Scrypt::calc($keyPhrase, hex2bin($addressCheck), 16384, 8, 8, 64));
        
        //split the derived data
        $derived_first = substr($derived, 0, 64);
        $derived_second = substr($derived, 64);
        
        //we get the private key
		$xor = self::hexXor($privateKeyHex, $derived_first);
		
		
        //encrypt the key using the second derived data
        $encrypt = openssl_encrypt(hex2bin($xor), "aes-256-ecb", hex2bin($derived_second), OPENSSL_NO_PADDING);

		// compile the string
		$compiledString = self::NEP_HEADER . self::NEP_FLAG . $addressCheck . bin2hex($encrypt);
				
		return Base58::checkEncode($compiledString,false,false,false);
    }


    /**
     * decrypt function.
     *
     * @access public
     * @static
     * @param mixed $encryptedKey
     * @param mixed $keyPhrase
     * @return void
     */

    static public function decrypt($encryptedKey, $keyPhrase)
    {

        //decode the hex and get only first 78 chars
        $decodedHex = substr(bin2hex(BcMathUtils::bc2bin(Base58::decode($encryptedKey))), 0, 78);

        //get address checksum
        $addressCheck = substr($decodedHex, 6, 8);

        //get the encrypted key part
        $encryptedKey = substr($decodedHex, -64);

        //derived passphrase
        $derived = bin2hex(Scrypt::calc($keyPhrase, hex2bin($addressCheck), 16384, 8, 8, 64));

        //split the derived data
        $derived_first = substr($derived, 0, 64);
        $derived_second = substr($derived, 64);

        //decrypt the key
        $decrypted = openssl_decrypt(hex2bin($encryptedKey), "aes-256-ecb", hex2bin($derived_second), OPENSSL_NO_PADDING);

        //we get the private key
        if (!$privateKeyHex = self::hexXor(bin2hex($decrypted), $derived_first)) {
            throw new \Exception("Can't hexXor");
        }

        //let's verify: Get the address from the private key:
        $address = KeyPair::getAddressFromPrivateKey($privateKeyHex);

        //substring the address
        $addressCheck2 = substr(Hash::SHA256(Hash::SHA256($address), false), 0, 8);

        //and compare it to the saved hash
        if ($addressCheck == $addressCheck2)
            //return private key
            return $privateKeyHex;

        //couldnt compare it to logic
        return false;
    }

    /**
     * hexXor function.
     *
     * @access public
     * @static
     * @param mixed $str1
     * @param mixed $str2
     * @return void
     */

    static public function hexXor($str1, $str2)
    {
        //compare the lengths
        if (strlen($str1) != strlen($str2)) return false;

        //check if first string is dividable by 2
        if (strlen($str1) % 2 != 0) return false;

        $result = "";

        for ($i = 0; $i < strlen($str1); $i += 2) {
            $n1 = intval(substr($str1, $i, 2), 16);
            $n2 = intval(substr($str2, $i, 2), 16);
            //we need to pad this thing over here, PHP's dechex will not pad
            //a "1" with a zero...for some reason? i donno
            $result .= str_pad(BcmathUtils::bcdechex($n1 ^ $n2), 2, 0, STR_PAD_LEFT);
        }

        return $result;
    }
}



