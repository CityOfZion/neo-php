<?php
include("../vendor/autoload.php");

#test net or not
$neo = new \NeoPHP\NeoRPC(true);
#$neo->setNode($neo->getFastestNode());
$neo->setNode("http://seed5.neo.org:10332");

//set test address
$testAddress = "AQgvqUqGqoswu8bjArbpQSU2yCeTb1ifDT"; # Bittrex cold wallet

//Get balance
print_r($neo->getBalance($testAddress));

//Query the account asset information, according to the account address.
print_r($neo->getAccountState($testAddress));

//Query the asset information, based on the specified asset number.
print_r($neo->getAssetState(NeoPHP\NeoAssets::ASSET_GAS));
print_r($neo->getAssetState(NeoPHP\NeoAssets::ASSET_NEO));


//Returns the hash of the tallest block in the main chain.
print_r($neo->getBestBlockHash());

//Returns the corresponding block information according to the specified index OR hash.
print_r($neo->getBlock("0x56adb8cc0de3e4fff7b8641988c83bfca214802d263495403055efdd437234c4"));
print_r($neo->getBlock(1533325));

//Gets the number of blocks in the main chain.
print_r($neo->getBlockCount());

//Calculate system fees at a specific block
print_r($neo->getBlockSysFee($neo->getBlockCount() - 1));

//Returns the hash value of the corresponding block, based on the specified index.
print_r($neo->getBlockHash($neo->getBlockCount() - 1));

//Gets the current number of connections for the node.
print_r($neo->getConnectionCount());

//Query contract information, according to the contract script hash.
print_r($neo->getContractState("602c79718b16e442de58778e148d0b1084e3b2dffd5de6b7b16cee7969282de7"));

//Obtain the list of unconfirmed transactions in memory.
print_r($neo->getRawMemPool());

//Returns the corresponding transaction information, based on the specified hash value.
print_r($neo->getRawTransaction("602c79718b16e442de58778e148d0b1084e3b2dffd5de6b7b16cee7969282de7", true));

//Query contract information, according to the contract script hash.
print_r($neo->getStorage("c56f33fc6ecfcd0c225c4ab356fee59390af8560be0e930faebe74a6daff7c9b", "74657374"));

//Returns the corresponding transaction output information (returned change), based on the specified hash and index.
print_r($neo->getTxOut("0e3c0f477d80acda1c45650b3260e2410287ef78c291f6e02f0214daca2bd2cf", 0));

//Broadcasts a transaction over the NEO network. There are many kinds of transactions, as specified in the network protocol documentation <http://docs.neo.org/en-us/node/network-protocol.html>
$broadcastTransaction = $neo->sendRawTransaction("80000001195876cb34364dc38b730077156c6bc3a7fc570044a66fbfeeea56f71327e8ab0000029b7cffdaa674beae0f930ebe6085af9093e5fe56b34a5c220ccdcf6efc336fc500c65eaf440000000f9a23e06f74cf86b8827a9108ec2e0f89ad956c9b7cffdaa674beae0f930ebe6085af9093e5fe56b34a5c220ccdcf6efc336fc50092e14b5e00000030aab52ad93f6ce17ca07fa88fc191828c58cb71014140915467ecd359684b2dc358024ca750609591aa731a0b309c7fb3cab5cd0836ad3992aa0a24da431f43b68883ea5651d548feb6bd3c8e16376e6e426f91f84c58232103322f35c7819267e721335948d385fae5be66e7ba8c748ac15467dcca0693692dac");
if ($broadcastTransaction)
    echo "Sent";
else
    echo "Hasn't been sent";

//validate address and address
if ($neo->validateAddress("AXCLjFvfi47R1sKLrebbRJnqWgbcsncfro"))
    echo "Address is valid";
else
    echo "Address is not valid";