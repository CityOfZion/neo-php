<?php
namespace NeoPHP\Crypto;

use NeoPHP\NeoPHP;

class NEP2 {

	const NEP_HEADER = '0142';
	const NEP_FLAG = 'e0';
	const SCRYPT_OPTS = array(
		"cost" => 16384,
		"blockSize" => 8,
		"parallel" => 8,
		"size" => 64
	);

	static public function encrypt($privateKey, $keyphrase) {
		return "encrypted key";
	}
	
	static public function decrypt($encryptedKey, $keyphrase) {
		return "decrypted key pair";	   
	}
}
