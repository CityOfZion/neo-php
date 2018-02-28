<?php
include("../vendor/autoload.php");

//Existing wallet and encrypt it with NEP2
$wallet = new NeoPHP\NeoWallet("Kx1wAGBe7tSQHq52rLbt9rQRjofrBpCvE1rBk7JftD5Z1gu6WcXm");

//encrypt it with the password test1234
$wallet->encryptWallet("test1234");

echo "Your encrypted key is: ".$wallet->getEncryptedKey()."\n";