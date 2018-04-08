<?php
namespace NeoPHP;

use NeoPHP\Assets\NeoAssets;

/**
 * Class NeoRPC
 *
 * @package PHPNeo
 */
class NeoNEP5
{
    /**
      * getNEP5Balance function.
      *
      * @access public
      * @param mixed $rpcObject
      * @param mixed $asset
      * @param mixed $address
      * @return float
      */
    public static function getTokenBalance($rpcObject, $asset, $address)
    {
        //get scripthash from address
        $hash = \NeoPHP\Crypto\WIF::getScriptHashFromAddress($address);

        //get reverse hex
        $addressScriptHashReverse = \NeoPHP\Tools\StringTools::reverseHex($hash);
        
        //script hash
        $script_hash = NeoAssets::getHash($asset);

        //get decimals
        $decimals = NeoAssets::getDecimals($asset);
        
        //create new parameter object
        $p = new SmartContract\Parameters();

        //adding a parameter
        $p->addParameter(
            $p::PARAMETER_ADDRESS,
            $address
        );
        
        //perform the RPC request
        $params = $p->getParameters();
        $request = $rpcObject->invokeFunction($script_hash, ["balanceOf", $params]);
        
        //reverse the hex decimal
        $value = $request['stack'][0]['value'];
        $hexDecimal = \NeoPHP\Tools\StringTools::reverseHex($value);
        
        //intval (#, 16) where 16 is the hex deicmal
        return intval($hexDecimal, 16) / pow(10, $decimals);
    }
}
