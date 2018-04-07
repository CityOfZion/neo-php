<?php
namespace NeoPHP\Assets;

/**
 * Class NeoAsset
 *
 * @package PHPNeo
 */
class NeoAssets
{
    const ASSET_GAS = array(
        "name" => "GAS",
        "hash" => "602c79718b16e442de58778e148d0b1084e3b2dffd5de6b7b16cee7969282de7",
        "system_token" => true,
        "decimals" => 8,
        "cmc_id" => "gas"
    );

    const ASSET_NEO = array(
        "name" => "NEO",
        "hash" => "c56f33fc6ecfcd0c225c4ab356fee59390af8560be0e930faebe74a6daff7c9b",
        "system_token" => true,
        "decimals" => 8,
        "cmc_id" => "neo"
    );
    
    const ASSET_TKY = array(
        "name" => "The Key",
        "hash" => "132947096727c84c7f9e076c90f08fec3bc17f18",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => "thekey"
    );

    const ASSET_ONT = array(
        "name" => "Ontology",
        "hash" => "ceab719b8baa2310f232ee0d277c061704541cfb",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => "ontology"
    );
    
    const ASSET_CGE = array(
        "name" => "Congierce token",
        "hash" => "34579e4614ac1a7bd295372d3de8621770c76cdc",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id"=>false
    );

    const ASSET_ACAT = array(
        "name" => "Alphacat",
        "hash" => "7f86d61ff377f1b12e589a5907152b57e2ad9a7a",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => "alphacat"
    );
    
    const ASSET_NRVE = array(
        "Narrative Token",
        "hash" => "a721d5893480260bd28ca1f395f2c465d0b5b1c2",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => false
    );
    
    const ASSET_RPX = array(
        "cmc_id" => "Red Pulse",
        "hash" => "ecc6b20d3ccac1ee9ef109af5a7cdb85706b1df9",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => "red-pulse"
    );
    
    const ASSET_DBC = array(
        "name" => "DeepBrainChain",
        "hash" => "b951ecbbc5fe37a9c280a76cb0ce0014827294cf",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => "deepbrain-chain"
    );
    
    const ASSET_QLC = array(
        "name" => "Qlink Token",
        "hash" => "0d821bd7b6d53f5c2b40e217c6defc8bbe896cf5",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => "qlink"
    );
    
    const ASSET_TNC = array(
        "name" => "Trinity Network Credit",
        "hash" => "08e8c4400f1af2c20c28e0018f29535eb85d15b6",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => "trinity-network-credit"
    );
        
    const ASSET_ZPT = array(
        "name" => "Zeepin",
        "hash" => "ac116d4b8d4ca55e6b6d4ecce2192039b51cccc5",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => "zeepin"
    );

    const ASSET_PKC = array(
        "name" => "pikciochain",
        "hash" => "af7c7328eee5a275a3bcaee2bf0cf662b5e739be",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => false
    );
    
    const ASSET_THR = array(
        "name" => "Thor Token",
        "hash" => "67a5086bac196b67d5fd20745b0dc9db4d2930ed",
        "system_token" => false,
        "decimals" => 8,
        "cmc_id" => false
    );


    /**
     * validateAsset function.
     *
     * @access private
     * @param mixed $asset
     * @return void
     */
    private static function validateAsset($asset)
    {
        if (!is_array($asset)) {
            throw new \Exception("Not a valid asset (NOT_CONST_ARR)");
        }

        if (!array_key_exists("hash", $asset) || !array_key_exists("system_token", $asset)) {
            throw new \Exception("Not a valid asset");
        }
    }

    /**
     * getName function.
     *
     * @access public
     * @static
     * @param mixed $asset
     * @return void
     */
    public static function getName($asset)
    {
        self::validateAsset($asset);
        return $asset['name'];
    }

    /**
     * getHash function.
     *
     * @access public
     * @static
     * @param mixed $asset
     * @return void
     */
    public static function getHash($asset)
    {
        self::validateAsset($asset);
        return $asset['hash'];
    }

    /**
     * isSystemToken function.
     *
     * @access public
     * @static
     * @param mixed $asset
     * @return void
     */
    public static function isSystemToken($asset)
    {
        self::validateAsset($asset);
        return $asset['system_token'];
    }
    
    /**
     * getDecimals function.
     *
     * @access public
     * @static
     * @param mixed $asset
     * @return void
     */
    public static function getDecimals($asset)
    {
        self::validateAsset($asset);
        return $asset['decimals'];
    }

    /**
     * getCoinMarketcapId function.
     *
     * @access public
     * @static
     * @param mixed $asset
     * @return void
     */
    public static function getCoinMarketCapId($asset)
    {
        self::validateAsset($asset);
        return $asset['cmc_id'];
    }
}
