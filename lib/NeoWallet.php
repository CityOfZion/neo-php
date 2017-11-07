<?php
namespace NeoPHP;

class NeoWallet {
	
	/**
	 * newNeoWallet function.
	 * 
	 * @access public
	 * @return void
	 */
	public static function newNeoWallet() {
		//Create a simple array privatekey
		$privateKeyHex = Crypto\KeyPair::createPrivateKeyHex();
		$publicKeyHex  = Crypto\KeyPair::getPublicKeyFromPrivateKey($privateKeyHex);

		
		//get the WIF from the private key
		$neoWallet = array(
			"wif"=>Crypto\WIF::createWifFromPrivateKey($privateKeyHex),
 			"private_key_hex" => $privateKeyHex,
			"public_key_hex" => $publicKeyHex
//			"address" => self::getAddressFromPublicKey($publicKeyHex),
		);
		
		return $neoWallet;
	}
	


}
