<?php
	function _require_all($dir) {
        // require all php files
        $scan = glob("$dir/*");
        foreach ($scan as $path) {
            if (preg_match('/\.php$/', $path)) {
                require_once $path;
            }
            elseif (is_dir($path)) {
                _require_all($path);
            }
        }
    }
    _require_all("./../src/");

	//Existing wallet encrypted with NEP2
	$existingWallet = new NeoPHP\NeoWallet("6PYPUvTG4a5cpCEha4ew6GSx2WDsKnu2CQb3sVwkgzvnsGRt4gyYw9roaf","test1234");
	print_r([
		"isNEP2" => (($existingWallet->isNEP2()) ? "🔒" : "🚫"),
		"encryptedKey" => $existingWallet->getEncryptedKey(),
		"wif" => $existingWallet->getWif(),
		"address" => $existingWallet->getAddress(),
		"private_key" => $existingWallet->getPrivateKey(),
		"public_key" => $existingWallet->getPublicKey()
	]);
