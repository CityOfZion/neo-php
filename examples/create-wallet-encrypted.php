<?php
include("../vendor/autoload.php");

//New wallet
$newWallet = new NeoPHP\NeoWallet();
$newWallet->encryptWallet("test1234");
print_r([
    "is_nep2" => (($newWallet->isNEP2()) ? "🔒" : "🚫"),
    "encryptedKey" => $newWallet->getEncryptedKey(),
    "wif" => $newWallet->getWif(),
    "address" => $newWallet->getAddress(),
    "private_key" => $newWallet->getPrivateKey(),
    "public_key" => $newWallet->getPublicKey(),
]);
