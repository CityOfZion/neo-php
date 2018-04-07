<?php
namespace NeoPHP;

class NeoWallet
{
    private $privateKeyHex = null;
    private $wif = null;
    private $publicKeyHex = null;
    private $isEncrypted = false;
    private $encryptedKey = null;
    private $isTestNet = false;


    /**
     * newNeoWallet function.
     *
     * @access public
     * @return void
     */

    public function __construct($addressInput = false, $keyPhrase = false)
    {
        if ($addressInput != "" && $keyPhrase != "") {
            if (!$this->privateKeyHex = Crypto\NEP2::decrypt($addressInput, $keyPhrase)) {
                $error = sprintf("Can't decrypt key: %s", $addressInput);
                throw new \Exception($error);
            }

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
     * setTestNet function.
     *
     * @access public
     * @param mixed $isTestNet
     * @return void
     */
    public function setTestNet($isTestNet=true)
    {
        $this->isTestNet = $isTestNet;
    }


    /**
     * encryptWallet function.
     *
     * @access public
     * @param mixed $keyPhrase
     * @return void
     */
    public function encryptWallet($keyPhrase)
    {
        if (!$keyPhrase || $keyPhrase == "") {
            throw new \Exception("No passphrase set");
        }
    
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
        if (!isset($this->publicKeyHex)) {
            $this->publicKeyHex = Crypto\KeyPair::getPublicKeyFromPrivateKey($this->privateKeyHex);
        }

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
        if (!$this->isEncrypted) {
            throw new \Exception("This is not an encrypted key");
        }

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
    
    
    /**
     * transferAssets function.
     *
     * @access public
     * @param mixed $toAddress
     * @param mixed $asset
     * @param int $amount (default: 0)
     * @return void
     */
    public function createTransaction($asset = "", $amount = 0, $toAddress = "")
    {
        if (trim($asset) == "") {
            throw new \Exception("Invalid or empty asset id");
        }
        
        if (floatval($amount) <= 0) {
            throw new \Exception("Amount must be greater than 0");
        }
        
        if (trim($toAddress) == "") {
            throw new \Exception("Address can't be empty");
        }
        
        echo "\n\n--------SENDING FUNDS---------\n";
        echo "What:\t\t{$asset}\n";
        echo "Address:\t{$toAddress}\n";
        echo "Amount:\t\t{$amount}\n";
        echo "------------------------------\n\n\n";
        
        
        //set empty variables
        $sortedUnspents = 0;
        $neededForTransaction = array();
        
        //Do a call to COZ for the balance
        $NeoRPC = new NeoRPC($this->isTestNet);
        $balance = $NeoRPC->getBalance($this->getAddress());

        if ($asset == NeoAssets::ASSET_NEO) {
            if ($balance['NEO']['balance'] < $amount) {
                throw new \Exception("Not enough NEO to do this transaction, only {$balance['NEO']['balance']} available");
            }
            $sortedUnspents = $balance['NEO']['unspent'];
        } elseif ($asset == NeoAssets::ASSET_GAS) {
            if ($balance['GAS']['balance'] < $amount) {
                throw new \Exception("Not enough GAS to do this transaction, only {$balance['GAS']['balance']} available");
            }
            $sortedUnspents = $balance['GAS']['unspent'];
        }

        //sorting values descending
        usort($sortedUnspents, function ($a, $b) {
            return ($a['value'] < $b['value']) ? -1 : 1;
        });


        $runningAmount = 0.0;
        $index = 0;
        $count = 0;
        
        while ($runningAmount < $amount) {
            $neededForTransaction[] = $sortedUnspents[$index];
            $runningAmount = $runningAmount + $sortedUnspents[$index]['value'];
            $index++;
            $count++;
        }

        //start the count
        $inputData = [$count];
        
        //get the transactions
        foreach ($neededForTransaction as $t) {
            $reversedBytes = strrev(hex2bin($t['txid']));
            $inputData = array_merge($inputData, unpack("C*", $reversedBytes), array($t['index'],$t['index']));
        }

        
        $string = "";
        foreach ($inputData as $i) {
            $string .= dechex($i);
        }

        echo "Expect: 1d6b2a23526c9a46e3b6b87f6b8ac31d0654a84862d33088ba3aa2fe94d0801010\n";
        echo "String: {$string}\n";
        echo "Length: ".strlen($string);
        echo "\n\n";

        hex2bin($string);
        
        
        
        
        echo "proceeding";
    }
}
