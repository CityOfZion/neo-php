<?php
namespace NeoPHP\Crypto;

use NeoPHP\Crypto\Base58;

//taken from: https://en.bitcoin.it/wiki/Wallet_import_format


class WIF {
	
	public static function createWifFromPrivateKey($privateKey) {	
		return Base58::checkEncode(128, hex2bin($privateKey), true);
	}
	
/*
	public static function getPrivateKeyFromWif($wif) {
		return Base58::decode($wif);
	}
*/
	
}
