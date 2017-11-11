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
    _require_all("./../lib/");

	//Existing wallet
	$newWallet = new NeoPHP\NeoWallet();
	print_r(array(
		"private_key" => $newWallet->getPrivateKey(),
		"wif" => $newWallet->getWif(),
		"public_key" => $newWallet->getPublicKey()
	));
