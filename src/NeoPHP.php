<?php
namespace NeoPHP;


if (!extension_loaded('bcmath') ) {            
    throw new \ErrorException("Please install BCMATH");
}

if (!extension_loaded('curl') ) {            
    throw new \ErrorException("Please install cURL");
}

if (!extension_loaded('openssl') ) {            
    throw new \ErrorException("Please install cURL");
}


//use GMP if possible
if (!defined("USE_EXT"))
	define("USE_EXT","BCMATH");


/**
 * Class PHPNeo
 *
 * @package PHPNeo
 */ 
class NeoPHP {
    const NEO_PHP_VERSION = '0.0.1';
}

