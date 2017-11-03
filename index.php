<?php
	include("node.class.php");
	
	$neo = new PHPNeo();
	//$neo->setNode($neo->getFastestNode());
	$neo->setNode("http://seed5.neo.org:10332");

	//set test address
	$testAddress = "AG3cGA9iaiWnL6hH7mZPJPLkF6ngrsB3kB"; # Bittrex cold wallet
	$neoAssetID = "0xc56f33fc6ecfcd0c225c4ab356fee59390af8560be0e930faebe74a6daff7c9b";
	$gasAssetID = "0x602c79718b16e442de58778e148d0b1084e3b2dffd5de6b7b16cee7969282de7";
	//TODO: $rpxAssetID = "ecc6b20d3ccac1ee9ef109af5a7cdb85706b1df9";
	
	echo "<pre>";
	//Query the account asset information, according to the account address.
	#print_r($neo->getAccountState($testAddress));
	
	//Query the asset information, based on the specified asset number. 
	#print_r($neo->getAssetState($neoAssetID));
	#print_r($neo->getAssetState($gasAssetID));
	//TODO: print_r($neo->getAssetState($rpxAssetID));	

	//Returns the hash of the tallest block in the main chain.
	#print_r($neo->getBestBlockHash());

	//Returns the corresponding block information according to the specified index OR hash.
	#print_r($neo->getBlock("0x56adb8cc0de3e4fff7b8641988c83bfca214802d263495403055efdd437234c4"));
	#print_r($neo->getBlock(1533325));
	
	//Gets the number of blocks in the main chain.
	#print_r($neo->getBlockCount());
	
	//not sure what this does :-)
	#print_r($neo->getBlockSysFee($neo->getBlockCount()-1));
	
	//Returns the hash value of the corresponding block, based on the specified index.
	#print_r($neo->getBlockHash($neo->getBlockCount()-1));
	
	//Gets the current number of connections for the node.
	#print_r($neo->getConnectionCount());
	
	
	
	
	
	




//	$account_state = $neo->getAccountState($gasAssetID);
	
	
	//print_r($neo->getBlock($neo->getBlockCount()))."\n";
	
	
	//validate address
	//if ($neo->validateAddress("AXCLjFvfi47R1sKLrebbRJnqWgbcsncfro"))
	//	echo "Address is valid";
	//else
	//	echo "Address is not valid";
	
	
	
	
?>