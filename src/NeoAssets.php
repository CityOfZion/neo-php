<?php
namespace NeoPHP;
/**
 * Class NeoAsset
 *
 * @package PHPNeo
 */
class NeoAssets 
{
    const ASSET_GAS = array(
    	"hash" => "602c79718b16e442de58778e148d0b1084e3b2dffd5de6b7b16cee7969282de7",
    	"system_token" => true,
    	"decimals" => 8
    );

    const ASSET_NEO = array(
    	"hash" => "c56f33fc6ecfcd0c225c4ab356fee59390af8560be0e930faebe74a6daff7c9b",
    	"system_token" => true,
    	"decimals" => 8
    );
    
    const ASSET_TKY = array(
	    "hash" => "132947096727c84c7f9e076c90f08fec3bc17f18",
	    "system_token" => false,
    	"decimals" => 8
    );

    const ASSET_ONT = array(
	    "hash" => "ceab719b8baa2310f232ee0d277c061704541cfb",
	    "system_token" => false,
    	"decimals" => 8
    );
    
    const ASSET_CGE = array(
	    "hash" => "34579e4614ac1a7bd295372d3de8621770c76cdc",
	    "system_token" => false,
    	"decimals" => 8
    );

    const ASSET_ACAT = array(
	    "hash" => "7f86d61ff377f1b12e589a5907152b57e2ad9a7a",
	    "system_token" => false,
    	"decimals" => 8
    );
    
    const ASSET_NRVE = array(
	    "hash" => "a721d5893480260bd28ca1f395f2c465d0b5b1c2",
	    "system_token" => false,
    	"decimals" => 8
    );
    
	const ASSET_RPX = array(
    	"hash" => "ecc6b20d3ccac1ee9ef109af5a7cdb85706b1df9",
    	"system_token" => false,
    	"decimals" => 8
	);    
    
	const ASSET_DBC = array(
		"hash" => "b951ecbbc5fe37a9c280a76cb0ce0014827294cf",
		"system_token" => false,
    	"decimals" => 8
	);	
	
	const ASSET_QLC = array(
		"hash" => "0d821bd7b6d53f5c2b40e217c6defc8bbe896cf5",
		"system_token" => false,
    	"decimals" => 8
	);
	
	const ASSET_TNC = array(
		"hash" => "08e8c4400f1af2c20c28e0018f29535eb85d15b6",
		"system_token" => false,
    	"decimals" => 8
	);		    
    	
	const ASSET_ZPT = array(
		"hash" => "ac116d4b8d4ca55e6b6d4ecce2192039b51cccc5",
		"system_token" => false,
    	"decimals" => 8
	);

	const ASSET_PKC = array(
		"hash" => "af7c7328eee5a275a3bcaee2bf0cf662b5e739be",
		"system_token" => false,
    	"decimals" => 8
	);


	/**
	 * getHash function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $asset
	 * @return void
	 */
	public static function getHash($asset) {
		if (!is_array($asset))
            throw new \Exception("Not a valid asset");

		if (!array_key_exists("hash", $asset) || !array_key_exists("system_token", $asset))
            throw new \Exception("Not a valid asset");
        
        return  $asset['hash'];
	}
	
	/**
	 * getDecimals function.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function getDecimals($asset) {
		if (!is_array($asset))
            throw new \Exception("Not a valid asset");

		if (!array_key_exists("hash", $asset) || !array_key_exists("system_token", $asset))
            throw new \Exception("Not a valid asset");

        return $asset['decimals'];
        
	}

}


