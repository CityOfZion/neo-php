<?php
namespace NeoPHP;

class NeoWallet {

	
	/**
	 * privateKeyHex
	 * 
	 * (default value: null,$wif = null, $publicKeyHex = null)
	 * 
	 * @var mixed
	 * @access private
	 */
	private $privateKeyHex = null,$wif = null, $publicKeyHex = null, $isEncrypted = false;
	
	/**
	 * newNeoWallet function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct($addressInput = false,$passPhrase=false) {
		if ($addressInput && $passPhrase) {

			if (!$this->privateKeyHex = Crypto\NEP2::decrypt($addressInput,$passPhrase))
				throw new \Exception(sprintf("Can't decrypt key: %s",$addressInput));
				
			$this->isEncrypted = true;
			$this->wif = Crypto\WIF::getWifForPrivateKey($this->privateKeyHex);
			
		} else {
			if (!$addressInput) {
				$this->privateKeyHex = Crypto\KeyPair::createPrivateKeyHex();
				$this->wif = Crypto\WIF::getWifForPrivateKey($this->privateKeyHex);
			} else {
				if (Crypto\WIF::validateWif($addressInput)) {
					$this->privateKeyHex = Crypto\WIF::getPrivateKeyFromWif($addressInput);
					$this->wif = $addressInput;
				} else {
					throw new \Exception("Invalid WIF");
				}
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


	/**
	 * getPublicKey function.
	 * 
	 * @access public
	 * @return void
	 */
	public function getPublicKey() {
		
		if (!isset($this->wif))
			throw new Exception("No WIF set");

		if (!isset($this->privateKeyHex))
			throw new Exception("No private key set");

		if (!isset($this->publicKeyHex))
			$this->publicKeyHex = Crypto\KeyPair::getPublicKeyFromPrivateKey($this->privateKeyHex);
			
		return $this->publicKeyHex;
	}
	
	
	/**
	 * getWIF function.
	 * 
	 * @access public
	 * @return void
	 */
	public function getWIF() {
		if (!isset($this->wif))
			$this->wif = Crypto\WIF::getWifForPrivateKey($this->privateKeyHex);

		return $this->wif;
	}
	
	/**
	 * getAddress function.
	 * 
	 * @access public
	 * @return void
	 */
	public function getAddress() {
		if (!isset($this->wif))
			throw new Exception("No WIF set");

		$publicKeyHex = $this->getPublicKey();
		
		return Crypto\KeyPair::getAddressFromPublicKey($publicKeyHex);
	}
	
	
	/**
	 * isNep2 function.
	 * 
	 * @access public
	 * @return void
	 */
	public function isNep2() {
		return $this->isEncrypted;
	}

}
