<?php

namespace NeoPHP;

use NeoPHP\RPCRequest;

class NeoRPC
{

    /**
     * nodes
     *
     * @var mixed
     * @access public
     */

    var $nodes;

    /**
     * active_node
     *
     * @var mixed
     * @access public
     */

    var $active_node;

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */

    function __construct($useMainNet = true)
    {
        if ($useMainNet)
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
        else
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

    /*
    @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    @@ Var getters and setters functions
    @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    */
    /**
     * setNode function.
     *
     * @access public
     * @return void
     */

    public function setNode($node)
    {
        if (filter_var($node, FILTER_VALIDATE_URL) === FALSE)
            throw new \Exception("Node not a valid URL");
        $this->active_node = $node;
    }

    /**
     * getNode function.
     *
     * @access public
     * @return void
     */

    public function getNode()
    {
        return $this->active_node;
    }

    /**
     * listNodes function.
     *
     * @access public
     * @return void
     */

    public function listNodes()
    {
        return $this->nodes;
    }

    /**
     * getFastestNode function.
     *
     * @access public
     * @return void
     */

    public function getFastestNode()
    {
        $connection_time = 100;
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
            if ($connection_time > $node['total_time']) {
                $node['total_time'] = $connection_time;
                $fastest_node = $node['url'];
            }
        }
        return $fastest_node;
    }

    /**
     * getAccountState function.
     *
     * @access public
     * @param mixed $address
     * @return void
     */

    public function getAccountState($address)
    {
        if (!$address)
            throw new \Exception("Undefined address");
        return RPCRequest::request($this->active_node, "getaccountstate", [$address]);
    }

    /**
     * getAssetState function.
     *
     * @access public
     * @param mixed $asset : Asset ID
     * @return void
     */

    public function getAssetState($asset)
    {
        if (!$asset)
            throw new \Exception("Undefined asset");
        return RPCRequest::request($this->active_node, "getassetstate", [$asset]);
    }

    /**
     * getBestBlockHash function.
     *
     * @access public
     * @return void
     */

    public function getBestBlockHash()
    {
        return RPCRequest::request($this->active_node, "getbestblockhash");
    }

    /**
     * getBlock function.
     *
     * @access public
     * @param bool $block_identifier (default: false)
     * @param bool $verbose (default: true) Optional, the default value of verbose is 0. When verbose is 0, the serialized information of the block is returned, represented by a hexadecimal string. If you need to get detailed information, you will need to use the SDK for deserialization. When verbose is 1, detailed information of the corresponding block in Json format string, is returned
     * @return void
     */

    public function getBlock($block_identifier = false, $verbose = true)
    {
        if (!$block_identifier)
            throw new \Exception("Undefined block identifier");
        return RPCRequest::request($this->active_node, "getblock", [$block_identifier, $verbose]);
    }

    /**
     * getBlockCount function.
     *
     * @access public
     * @return void
     */

    public function getBlockCount()
    {
        return RPCRequest::request($this->active_node, "getblockcount");
    }

    /**
     * getBlockSysFee function.
     *
     * @access public
     * @param mixed $block_identifier
     * @return void
     */

    public function getBlockSysFee($block_identifier)
    {
        if (!$block_identifier)
            throw new \Exception("Undefined block identifier");
        return RPCRequest::request($this->active_node, "getblocksysfee", [$block_identifier]);
    }

    /**
     * getBlockHash function.
     *
     * @access public
     * @param mixed $block_index
     * @return void
     */

    public function getBlockHash($block_index)
    {
        if (!$block_index || !is_numeric($block_index))
            throw new \Exception("Not a valid numeric value");
        return RPCRequest::request($this->active_node, "getblockhash", [$block_index]);
    }

    /**
     * getConnectionCount function.
     *
     * @access public
     * @return void
     */

    public function getConnectionCount()
    {
        return RPCRequest::request($this->active_node, "getconnectioncount");
    }

    /**
     * getContractState function.
     *
     * @access public
     * @param mixed $script_hash
     * @return void
     */

    public function getContractState($script_hash)
    {
        if (!$script_hash)
            throw new \Exception("Empty script hash");
        return RPCRequest::request($this->active_node, "getcontractstate", [$script_hash]);
    }

    /**
     * getRawMemPool function.
     *
     * @access public
     * @return void
     */

    public function getRawMemPool()
    {
        return RPCRequest::request($this->active_node, "getrawmempool");
    }

    /**
     * getRawTransaction function.
     *
     * @access public
     * @param mixed $transaction_id
     * @param bool $verbose (default: true)
     * @return void
     */

    public function getRawTransaction($transaction_id, $verbose = true)
    {
        if (!$transaction_id)
            throw new \Exception("Empty transaction id");
        return RPCRequest::request($this->active_node, "getrawtransaction", [$transaction_id, $verbose]);
    }

    /**
     * getStorage function.
     *
     * @access public
     * @param mixed $script_hash
     * @return void
     */

    public function getStorage($script_hash)
    {
        if (!$script_hash)
            throw new \Exception("Empty script hash");

        if(!$key)
            throw new \Exception("Missing key");

        return RPCRequest::request($this->active_node, "getstorage", [$script_hash, $key]);
    }

    /**
     * getTxOut function.
     *
     * @access public
     * @param bool $transaction_id (default: false)
     * @param int $index (default: 0)
     * @return void
     */

    public function getTxOut($transaction_id = false, $index = 0)
    {
        if (!$transaction_id)
            throw new \Exception("Empty transaction id");

        return RPCRequest::request($this->active_node, "gettxout", [$transaction_id, $index]);
    }

    /**
     * sendRawTransaction function.
     *
     * @access public
     * @param mixed $hex
     * @return void
     */

    public function sendRawTransaction($hex)
    {
        if (!$hex)
            throw new \Exception("Empty hex string");
        return RPCRequest::request($this->active_node, "sendrawtransaction", [$hex]);

    }

    /**
     * validateAddress function.
     *
     * @access public
     * @param mixed $address
     * @return void
     */

    public function validateAddress($address)
    {
        if (!$address)
            throw new \Exception("Undefined address");
        return RPCRequest::request($this->active_node, "validateaddress", [$address])['isvalid'];
    }

    /**
     * getPeers function.
     *
     * @access public
     * @return void
     */

    public function getPeers()
    {
        return RPCRequest::request($this->active_node, "getpeers");
    }
}
