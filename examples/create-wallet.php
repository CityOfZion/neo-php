<?php
include("../../../../vendor/autoload.php");

//New wallet
$newWallet = new NeoPHP\NeoWallet();
print_r([
    "is_nep2" => (($newWallet->isNEP2()) ? "🔒" : "🚫"),
    "wif" => $newWallet->getWif(),
    "address" => $newWallet->getAddress(),
    "private_key" => $newWallet->getPrivateKey(),
    "public_key" => $newWallet->getPublicKey()
]);
