<?php

include("../vendor/autoload.php");

//Existing wallet
$existingNEP2EncryptedWallet = new NeoPHP\NeoWallet("6PYPUvTG4a5cpCEha4ew6GSx2WDsKnu2CQb3sVwkgzvnsGRt4gyYw9roaf", "test1234");
print_r([
    "is_nep2" => (($existingNEP2EncryptedWallet->isNEP2()) ? "🔒" : "🚫"),
    "wif" => $existingNEP2EncryptedWallet->getWif(),
    "address" => $existingNEP2EncryptedWallet->getAddress(),
    "private_key" => $existingNEP2EncryptedWallet->getPrivateKey(),
    "public_key" => $existingNEP2EncryptedWallet->getPublicKey()
]);
