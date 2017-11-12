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

	//New wallet
	$newWallet = new NeoPHP\NeoWallet();
	print_r(array(
		"isNep2" => (($newWallet->isNep2()) ? "🔒" : "🚫"),
		"wif" => $newWallet->getWif(),
		"address" => $newWallet->getAddress(),
		"private_key" => $newWallet->getPrivateKey(),
		"public_key" => $newWallet->getPublicKey()
	));
