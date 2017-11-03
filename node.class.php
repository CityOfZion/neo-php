<?php
define("_PHPNEO_VERSION_","1.0");
class PHPNeo {

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
	function __construct() {
		$this->nodes = array(
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
		);
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
	public function setNode($node) {
		if (filter_var($node, FILTER_VALIDATE_URL) === FALSE)
		    throw new Exception("Node not a valid URL");
		$this->active_node = $node;
	}

	/**
	 * getNode function.
	 * 
	 * @access public
	 * @return void
	 */
	public function getNode() {
		return $this->active_node;
	}
			
	/**
	 * listNodes function.
	 * 
	 * @access public
	 * @return void
	 */
	public function listNodes() {
		return $this->nodes;
	}

	/*
		@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		@@ Public functions
		@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@	
	*/
	/**
	 * getFastestNode function.
	 * 
	 * @access public
	 * @return void
	 */
	public function getFastestNode() {
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


	/*
		@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		@@ API Functions functions
		@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@	
	*/


	public function getAccountState($address) {
		if (!$address)
			throw new Exception("Undefined address");		
		return $this->rpcRequest($this->active_node,"getaccountstate",array($address));
	}
	
	public function getAssetState($asset) {
		if (!$asset)
			throw new Exception("Undefined asset");		
		return $this->rpcRequest($this->active_node,"getassetstate",array($asset));
	}

	public function getBestBlockHash() {
		return $this->rpcRequest($this->active_node,"getbestblockhash");
	}
	
	public function getBlock($block_identifier=false,$verbose=true) {
		if (!$block_identifier)
			throw new Exception("Undefined block identifier");
		return $this->rpcRequest($this->active_node,"getblock",array($block_identifier,$verbose));
	}
	
	public function getBlockCount() {
		return $this->rpcRequest($this->active_node,"getblockcount");
	}
	
	public function getBlockSysFee($block_identifier) {
		if (!$block_identifier)
			throw new Exception("Undefined block identifier");

		return $this->rpcRequest($this->active_node,"getblocksysfee",array($block_identifier));		
	}	
	
	public function getBlockHash($block_index) {
		if (!$block_index || !is_numeric($block_index))
			throw new Exception("Not a valid numeric value");
		return $this->rpcRequest($this->active_node,"getblockhash",array($block_index));
	}

	public function getConnectionCount() {
		return $this->rpcRequest($this->active_node,"getconnectioncount");
	}
	

	
	
	







	public function validateAddress($address) {
		if (!$address)
			throw new Exception("Undefined address");
		return $this->rpcRequest($this->active_node,"validateaddress",array($address))['isvalid'];
	}
	
	
	
	
	/*
		@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		@@ cURL request functions
		@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@	
	*/
	/**
	 * rpcRequest function.
	 * 
	 * @access public
	 * @param bool $node (default: false)
	 * @param bool $method (default: false)
	 * @param array $params (default: array())
	 * @return void
	 */
	private function rpcRequest($node=false, $method=false, $params=array()) {

		if (!$node)
			throw("No node defined");
		
		if (!$method)
			throw("No method defined");

		$data_array = json_encode(array(
			"jsonrpc"=> "2.0",
			"method" => $method,
			"params" => $params,
			"id"	 => 0,
		));
		
		$ch = curl_init($node);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_array);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'PHPNeo '. _PHPNEO_VERSION_);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($data_array)
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				
		$result = curl_exec($ch);
		$errno = curl_errno($ch);
		
		if ($result === false) {
		  throw("cURL Error: ".curl_error($ch));
		  curl_close($ch);
		}
		
		$json_return = json_decode($result,true);
		if (json_last_error() != 0)
			throw("Json not valid: ".json_last_error_msg());
			
		
		if (isset($json_return['error'])) {
			$error = $json_return['error']['message'];
			throw new Exception("RPC Error message: ".$error);
		}

		curl_close($ch);
		return $json_return['result'];
	}
	
		
	
}