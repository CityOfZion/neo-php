<?php

namespace NeoPHP;

class RPCRequest
{

    public static function request($node = false, $method = false, $params = [])
    {

        if (!$node)
            throw new \Exception("No node defined");

        if (!$method)
            throw new \Exception("No method defined");

        $data_array = json_encode([
            "jsonrpc" => "2.0",
            "method" => $method,
            "params" => $params,
            "id" => 0,
        ]);

        $ch = curl_init($node);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_array);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHPNeo ' . NeoPHP::NEO_PHP_VERSION);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_array)
        ]);


        $result = curl_exec($ch);
        $errno = curl_errno($ch);

        if ($result === false) {
            throw new \Exception("cURL Error: " . curl_error($ch));
            curl_close($ch);
        }

        $json_return = json_decode($result, true);
        if (json_last_error() != 0)
            throw new \Exception("Json not valid: " . json_last_error_msg());


        if (isset($json_return['error'])) {
            $error = $json_return['error']['message'];
            throw new \Exception("RPC Error message: " . $error);
        }

        curl_close($ch);
        return $json_return['result'];
    }
}
