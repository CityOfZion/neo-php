<?php
namespace NeoPHP\Crypto;

use NeoPHP\Crypto\Base58;


//taken from: https://en.bitcoin.it/wiki/Wallet_import_format


class WIF {
	
	public static function createWifFromPrivateKey($privateKey) {
		return array(
			"private_key_hex" => bin2hex($privateKey),
			"private_key_compressed" => "120".bin2hex($privateKey)."01",
			"wif" => Base58::checkEncode(0x80, $privateKey, 0x01)
		);
	}
	
	public static function getPrivateKeyFromWif($wif) {
		return Base58::decode($wif);
	}
	
}
