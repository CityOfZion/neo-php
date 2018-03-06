<?php
namespace NeoPHP;

class NEP5
{
   /**
     * getNEP5Balance function.
     * 
     * @access public
     * @param mixed $asset
     * @param mixed $address
     * @return void
     */
    public static function getTokenBalance($rpcObject, $asset,$address) 
    {

	    //get scripthash from address
	    $addressScriptHash = \NeoPHP\Crypto\WIF::getScriptHashFromAddress($address);

	    //get reverse hex
	    $addressScriptHashReverse = \NeoPHP\Tools\StringTools::reverseHex($addressScriptHash);
	    
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
		$request = $rpcObject->invokeFunction($script_hash, ["balanceOf",$p->getParameters()]);
		
		//reverse the hex decimal
		$hexDecimal = \NeoPHP\Tools\StringTools::reverseHex($request['stack'][0]['value']);
		
		//intval (#, 16) where 16 is the hex deicmal
		return intval($hexDecimal,16) / pow(10,$decimals);
    }
	
}
