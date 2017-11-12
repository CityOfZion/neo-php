<?php
function _require_all($dir)
{
    // require all php files
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        if (preg_match('/\.php$/', $path)) {
            require_once $path;
        } elseif (is_dir($path)) {
            _require_all($path);
        }
    }
}

_require_all("./../src/");

//New wallet
$newWallet = new NeoPHP\NeoWallet();
$newWallet->encryptWallet("test1234");
print_r([
    "isNEP2" => (($newWallet->isNEP2()) ? "🔒" : "🚫"),
    "encryptedKey" => $newWallet->getEncryptedKey(),
    "wif" => $newWallet->getWif(),
    "address" => $newWallet->getAddress(),
    "private_key" => $newWallet->getPrivateKey(),
    "public_key" => $newWallet->getPublicKey(),
]);