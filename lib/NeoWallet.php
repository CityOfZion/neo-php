<?php
namespace NeoPHP;

use NeoPHP\Crypto\Base58;

class NeoWallet {
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	function __construct() {
		
	}
	
	/**
	 * newNeoWallet function.
	 * 
	 * @access public
	 * @return void
	 */
	public static function newNeoWallet() {
		//Create a simple array privatekey
		$privateKey = self::createPrivateKey();
		
		$wif = Crypto\WIF::createWifFromPrivateKey($privateKey);
		
		$keyPair = array(
			"wif" => $wif['wif'],
			"privateKey" => bin2hex($privateKey)
		);
		
		return $keyPair;
	}
	
	/**
	 * getWIFFromPrivateKey function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $privateKey
	 * @return void
	 */
	
	
	/**
	 * createPrivateKey function.
	 * 
	 * @access private
	 * @return void
	 */
	static private function createPrivateKey() {
		return openssl_random_pseudo_bytes(32);
	}
		
}
