<?php

namespace NeoPHP\Crypto;

class Hash
{
    public static function SHA256($data, $raw = true)
    {
        return hash('sha256', $data, $raw);
    }

    public static function RIPEMD160($data, $raw = true)
    {
        return hash('ripemd160', $data, $raw);
    }
}
