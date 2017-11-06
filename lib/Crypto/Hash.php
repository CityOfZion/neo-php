<?php
namespace NeoPHP\Crypto;

class Hash {
	
    public static function SHA256($data) {
	    return hash('sha256', $data,true);
    }
    
    public static function RIPEMD160($data) {
	    return hash('ripemd160', $data);	    
    }
}
