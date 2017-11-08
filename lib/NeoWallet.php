<?php
namespace NeoPHP;

class NeoWallet {

	
	private $privateKeyHex = null,$wif = null, $publicKeyHex = null;

    	
	
	/**
	 * newNeoWallet function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct($walletWif = false) {
		
		if (!$walletWif) {
			$this->privateKeyHex = Crypto\KeyPair::createPrivateKeyHex();
			$this->wif = Crypto\WIF::createWifFromPrivateKey($this->privateKeyHex);
		} else {
			if (Crypto\WIF::validateWif($walletWif)) {
				$this->privateKeyHex = Crypto\WIF::getPrivateKeyFromWif($walletWif);
				$this->wif = $walletWif;
			} else {
				throw new \Exception("Invalid WIF");
			}
		}
		return $this;
	}
	
	
	/**
	 * getPrivateKey function.
	 * 
	 * @access public
	 * @return void
	 */
	public function getPrivateKey() {
		return $this->privateKeyHex;
	}


	public function getPublicKey() {
		
		if (!isset($this->wif))
			throw new Exception("No WIF set");

		if (!isset($this->privateKeyHex))
			throw new Exception("No private key set");

		if (!isset($this->publicKeyHex))
			$this->publicKeyHex = Crypto\KeyPair::getPublicKeyFromPrivateKey($this->privateKeyHex);
			
		return $this->publicKeyHex;
	}
	
	public function getWIF() {
		if (!isset($this->wif))
			$this->wif = Crypto\WIF::createWifFromPrivateKey($this->privateKeyHex);

		return $this->wif;
	}
	
	public function getAddress() {
		if (!isset($this->wif))
			throw new Exception("No WIF set");
		
		self::getAddressFromPublicKey($publicKeyHex);
	}
	
	
	


}
