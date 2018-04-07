<?php
namespace NeoPHP;

use NeoPHP\Tools\NetworkRequest;
use NeoPHP\Assets\NeoAssets;

/**
 * Class NeoRPC
 *
 * @package PHPNeo
 */
class NeoRPC
{

    /**
     * nodes
     *
     * @var array|null
     * @access public
     */

    public $nodes;

    /**
     * active_node
     *
     * @var string|null
     * @access public
     */

    public $active_node;
    
    
    /**
     * useMainNet
     *
     * @var boolean|null
     * @access public
     */
    public $useMainNet;

    
    private static $requestCall;
    private static $rawResponse;


    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct($useMainNet = true)
    {
        $this->useMainNet = $useMainNet;
        if ($useMainNet) {
            $this->nodes = [
                "http://seed1.cityofzion.io:8080",
                "http://seed2.cityofzion.io:8080",
                "http://seed3.cityofzion.io:8080",
                "http://seed4.cityofzion.io:8080",
                "http://seed5.cityofzion.io:8080",
                "http://seed1.neo.org:10332",
                "http://seed2.neo.org:10332",
                "http://seed3.neo.org:10332",
                "http://seed4.neo.org:10332",
                "http://seed5.neo.org:10332"
            ];
        } else {
            $this->nodes = [
                "http://seed1.cityofzion.io:8880",
                "http://seed2.cityofzion.io:8080",
                "http://seed3.cityofzion.io:8080",
                "http://seed4.cityofzion.io:8880",
                "http://seed5.cityofzion.io:8880",
                "http://seed1.neo.org:20332",
                "http://seed2.neo.org:20332",
                "http://seed3.neo.org:20332",
                "http://seed4.neo.org:20332",
                "http://seed5.neo.org:20332"
            ];
        }
    }

    /*
    @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    @@ Var getters and setters functions
    @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    */


    /**
     * setNode function.
     *
     * @access public
     * @param string $node
     * @return void
     */
    public function setNode($node)
    {
        if (filter_var($node, FILTER_VALIDATE_URL) === false) {
            throw new \Exception("Node not a valid URL");
        }
        $this->active_node = $node;
    }

    /**
     * getNode function.
     *
     * @access public
     * @return string|null
     */

    public function getNode()
    {
        return $this->active_node;
    }

    /**
     * listNodes function.
     *
     * @access public
     * @return array
     */

    public function listNodes()
    {
        return $this->nodes;
    }

    /**
     * getFastestNode function.
     *
     * @access public
     * @return string
     */
    public function getFastestNode()
    {
        $connection_time = PHP_INT_MAX;
        $connections = [];
        $fastest_node = false;
        $mh = curl_multi_init();
        foreach ($this->nodes as $i => $url) {
            $connections[$i] = curl_init($url);
            curl_setopt($connections[$i], CURLOPT_RETURNTRANSFER, 1);
            curl_multi_add_handle($mh, $connections[$i]);
        }
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        foreach ($connections as $connection) {
            $node = curl_getinfo($connection);

            $isValidResponse = $node['http_code'] === 200;
            $isLowerLatency = $connection_time > $node['total_time'];

            if ($isValidResponse && $isLowerLatency) {
                $node['total_time'] = $connection_time;
                $fastest_node = $node['url'];
            }
        }
        return $fastest_node;
    }
    
    
    /**
     * setShowRequest function.
     *
     * @access public
     * @param bool $showRequest (default: false)
     * @return void
     */
    public function setShowRequest($showRequest=false)
    {
        $this->showRequest = $showRequest;
    }

    /**
     * getAccountState function.
     *
     * @access public
     * @param mixed $address
     * @return mixed
     */

    public function getAccountState($address)
    {
        if (!$address) {
            throw new \Exception("Undefined address");
        }
            
        return self::doRPCRequest($this->active_node, "getaccountstate", [$address]);
    }

    /**
     * getAssetState function.
     *
     * @access public
     * @param mixed $asset : Asset ID
     * @return string
     */

    public function getAssetState($asset)
    {
        if (!$asset) {
            throw new \Exception("Undefined asset");
        }
        
        $assetHash = NeoAssets::getHash($asset);
        
        return self::doRPCRequest($this->active_node, "getassetstate", [$assetHash]);
    }

    /**
     * getBestBlockHash function.
     *
     * @access public
     * @return mixed
     */

    public function getBestBlockHash()
    {
        return self::doRPCRequest($this->active_node, "getbestblockhash");
    }

    /**
     * getBlock function.
     *
     * @access public
     * @param bool $block_identifier (default: false)
     * @param bool $verbose (default: true) Optional, the default value of verbose is 0. When verbose is 0, the serialized information of the block is returned, represented by a hexadecimal string. If you need to get detailed information, you will need to use the SDK for deserialization. When verbose is 1, detailed information of the corresponding block in Json format string, is returned
     * @return mixed
     */

    public function getBlock($block_identifier = false, $verbose = true)
    {
        if (!$block_identifier) {
            throw new \Exception("Undefined block identifier");
        }
        return self::doRPCRequest($this->active_node, "getblock", [$block_identifier, $verbose]);
    }

    /**
     * getBlockCount function.
     *
     * @access public
     * @return mixed
     */

    public function getBlockCount()
    {
        return self::doRPCRequest($this->active_node, "getblockcount");
    }

    /**
     * getBlockSysFee function.
     *
     * @access public
     * @param mixed $block_identifier
     * @return mixed
     */

    public function getBlockSysFee($block_identifier)
    {
        if (!$block_identifier) {
            throw new \Exception("Undefined block identifier");
        }
        return self::doRPCRequest($this->active_node, "getblocksysfee", [$block_identifier]);
    }

    /**
     * getBlockHash function.
     *
     * @access public
     * @param mixed $block_index
     * @return mixed
     */

    public function getBlockHash($block_index)
    {
        if (!$block_index || !is_numeric($block_index)) {
            throw new \Exception("Not a valid numeric value");
        }
        return self::doRPCRequest($this->active_node, "getblockhash", [$block_index]);
    }

    /**
     * getConnectionCount function.
     *
     * @access public
     * @return mixed
     */

    public function getConnectionCount()
    {
        return self::doRPCRequest($this->active_node, "getconnectioncount");
    }

    /**
     * getContractState function.
     *
     * @access public
     * @param mixed $script_hash
     * @return mixed
     */

    public function getContractState($script_hash)
    {
        if (!$script_hash) {
            throw new \Exception("Empty script hash");
        }
        return self::doRPCRequest($this->active_node, "getcontractstate", [$script_hash]);
    }

    /**
     * getRawMemPool function.
     *
     * @access public
     * @return mixed
     */

    public function getRawMemPool()
    {
        return self::doRPCRequest($this->active_node, "getrawmempool");
    }

    /**
     * getRawTransaction function.
     *
     * @access public
     * @param mixed $transaction_id
     * @param bool $verbose (default: true)
     * @return mixed
     */

    public function getRawTransaction($transaction_id, $verbose = true)
    {
        if (!$transaction_id) {
            throw new \Exception("Empty transaction id");
        }
        return self::doRPCRequest($this->active_node, "getrawtransaction", [$transaction_id, $verbose]);
    }

    /**
     * getStorage function.
     *
     * @access public
     * @param mixed $script_hash
     * @return mixed
     */

    public function getStorage($script_hash, $key)
    {
        if (!$script_hash) {
            throw new \Exception("Empty script hash");
        }

        if (!$key) {
            throw new \Exception("Missing key");
        }

        return self::doRPCRequest($this->active_node, "getstorage", [$script_hash, $key]);
    }

    /**
     * getTxOut function.
     *
     * @access public
     * @param bool $transaction_id (default: false)
     * @param int $index (default: 0)
     * @return mixed
     */

    public function getTxOut($transaction_id = false, $index = 0)
    {
        if (!$transaction_id) {
            throw new \Exception("Empty transaction id");
        }

        return self::doRPCRequest($this->active_node, "gettxout", [$transaction_id, $index]);
    }

    /**
     * sendRawTransaction function.
     *
     * @access public
     * @param mixed $hex
     * @return mixed
     */

    public function sendRawTransaction($hex)
    {
        if (!$hex) {
            throw new \Exception("Empty hex string");
        }
        return self::doRPCRequest($this->active_node, "sendrawtransaction", [$hex]);
    }

    /**
     * validateAddress function.
     *
     * @access public
     * @param mixed $address
     * @return mixed
     */

    public function validateAddress($address)
    {
        if (!$address) {
            throw new \Exception("Undefined address");
        }
        return self::doRPCRequest($this->active_node, "validateaddress", [$address])['isvalid'];
    }

    /**
     * getPeers function.
     *
     * @access public
     * @return mixed
     */

    public function getPeers()
    {
        return self::doRPCRequest($this->active_node, "getpeers");
    }



    /**
     * invokeFunction function.
     *
     * @access public
     * @param mixed $script_hash
     * @param mixed $parameters
     * @return mixed
     */
    public function invokeFunction($script_hash, $parameters)
    {
        return self::doRPCRequest($this->active_node, "invokefunction", array_merge([$script_hash], $parameters));
    }

    /**
     * doRPCRequest function.
     *
     * @access public
     * @static
     * @param bool $node (default: false)
     * @param bool $method (default: false)
     * @param mixed $params (default: [])
     * @throws \Exception
     * @return mixed
     */
    public static function doRPCRequest($node = false, $method = false, $params = [])
    {

        //set node
        if (!$node) {
            throw new \Exception("No node defined");
        }

        //set method
        if (!$method) {
            throw new \Exception("No method defined");
        }

        //create new network request
        $r = new NetworkRequest();
        //set agent
        $r->setAgent('Neo-PHP ' . NeoPHP::NEO_PHP_VERSION);
        //data array
        self::$requestCall = json_encode([
            "jsonrpc" => "2.0",
            "method" => $method,
            "params" => $params,
            "id" => 1,
        ], JSON_PRETTY_PRINT);

        //set header
        $r->setHeaders(array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen(self::$requestCall)
        ));
        
        
        //printing
        if ($result = $r->post($node, self::$requestCall)) {
            self::$rawResponse = $result;
            
            if (isset($result['error'])) {
                $error = $result['error']['message'];
                throw new \Exception("RPC Error message: " . $error);
            }
            return $result['result'];
        } else {
            throw new \Exception("cURL Error: " . $r->getErrorMessage());
        }
    }
    
    public static function getRequestCall()
    {
        return self::$requestCall;
    }

    public static function getRawResponse()
    {
        return self::$rawResponse;
    }
    
    
    /**
     * getBalance function.
     *
     * @access public
     * @static
     * @param string $address (default: "")
     * @param mixed $isTestnet
     * @return mixed
     */
    public function getBalance($address="")
    {
        $accountState = self::getAccountState($address);
        $balances = $accountState['balances'];
        
        $returnArray = [
            "NEO"=>0,
            "GAS"=>0
        ];
        
        if (is_array($balances)) {
            foreach ($balances as $b) {
                if ($b['asset'] == "0x".NeoAssets::getHash(NeoAssets::ASSET_GAS)) {
                    $returnArray['GAS'] = $b['value'];
                } elseif ($b['asset'] == "0x".NeoAssets::getHash(NeoAssets::ASSET_NEO)) {
                    $returnArray['NEO'] = $b['value'];
                }
            }
        }
        return $returnArray;
    }
}
