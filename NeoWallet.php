<?php

namespace NeoPHP;

class NeoWallet
{


    /**
     * privateKeyHex
     *
     * (default value: null,$wif = null, $publicKeyHex = null)
     *
     * @var mixed
     * @access private
     */

    private $privateKeyHex = null, $wif = null, $publicKeyHex = null, $isEncrypted = false, $encryptedKey = null;


    /**
     * newNeoWallet function.
     *
     * @access public
     * @return void
     */

    public function __construct($addressInput = false, $keyPhrase = false)
    {
        if ($addressInput != "" && $keyPhrase != "") {
            if (!$this->privateKeyHex = Crypto\NEP2::decrypt($addressInput, $keyPhrase))
                throw new \Exception(sprintf("Can't decrypt key: %s", $addressInput));

            $this->isEncrypted = true;
            $this->wif = Crypto\WIF::getWifForPrivateKey($this->privateKeyHex);
            $this->encryptedKey = $addressInput;
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
	 * encryptWallet function.
	 * 
	 * @access public
	 * @param mixed $keyPhrase
	 * @return void
	 */
	public function encryptWallet($keyPhrase) {
		
		if (!$keyPhrase || $keyPhrase == "")
			throw new \Exception("No passphrase set");
	
		$this->isEncrypted = true;
		$this->encryptedKey = Crypto\NEP2::encrypt($this->privateKeyHex, $keyPhrase);
		
	}

    /**
     * getPrivateKey function.
     *
     * @access public
     * @return void
     */

    public function getPrivateKey()
    {
        return $this->privateKeyHex;
    }


    /**
     * getPublicKey function.
     *
     * @access public
     * @return void
     */

    public function getPublicKey()
    {
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

    public function getWIF()
    {
        return $this->wif;
    }


    /**
     * getAddress function.
     *
     * @access public
     * @return void
     */

    public function getAddress()
    {

        $publicKeyHex = $this->getPublicKey();
        return Crypto\KeyPair::getAddressFromPublicKey($publicKeyHex);
    }


    /**
     * getEncryptedKey function.
     *
     * @access public
     * @return void
     */

    public function getEncryptedKey()
    {
        if (!$this->isEncrypted)
            throw new \Exception("This is not an encrypted key");

        return $this->encryptedKey;
    }


    /**
     * isNEP2 function.
     *
     * @access public
     * @return void
     */

    public function isNEP2()
    {
        return $this->isEncrypted;
    }

}
