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

	$existingWallet = new NeoPHP\NeoWallet("L4XTNtTtbXHKQzTd7pstZHqfJ7viwDWxVoggPqaej38NLUvkMnNT");
	print_r(array(
		"wif" => $existingWallet->getWif(),
		"address" => $existingWallet->getAddress()
		"private_key" => $existingWallet->getPrivateKey(),
		"public_key" => $existingWallet->getPublicKey(),
	));
