<?php
include("../vendor/autoload.php");

//Existing wallet
$wallet = new NeoPHP\NeoWallet("KyQ3kwf81o74ideWjwr9ntQnd2pJYxx7JhkqzZ5ppJN81NadWj7c");
print_r([
    "is_nep2" => (($wallet->isNEP2()) ? "🔒" : "🚫"),
    "wif" => $wallet->getWif(),
    "address" => $wallet->getAddress(),
    "private_key" => $wallet->getPrivateKey(),
    "public_key" => $wallet->getPublicKey()
]);
