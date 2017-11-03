# neo-php
A NEO RPC wrapper in PHP

## A Lot work in progress :)

**Connecting**
```php
$neo = new NeoRPC(); #use true as argument to go to testnet
//$neo->setNode($neo->getFastestNode());
$neo->setNode("http://seed5.neo.org:10332");
```

**Query the account asset information, according to the account address.**

```php
$neo->getAccountState($testAddress);
```

**Query the asset information, based on the specified asset number.**

```php
$neo->getAssetState($neoAssetID);
```

**Returns the hash of the tallest block in the main chain.**

```php
$neo->getBestBlockHash();
```

**Returns the corresponding block information according to the specified index OR hash.**
```php
$neo->getBlock("0x56adb8cc0de3e4fff7b8641988c83bfca214802d263495403055efdd437234c4");
$neo->getBlock(1533325);
```

**Gets the number of blocks in the main chain.**

```php
$neo->getBlockCount();
```

**Calculate claim transaction amounts in order use sendrawtransaction to make a claim.**

```php
$neo->getBlockSysFee($neo->getBlockCount()-1);
```

**Returns the hash value of the corresponding block, based on the specified index.**

```php
$neo->getBlockHash($neo->getBlockCount()-1);
```

**Gets the current number of connections for the node.**

```php
$neo->getConnectionCount();
```

**Query contract information, according to the contract script hash.**

```php
$neo->getContractState("602c79718b16e442de58778e148d0b1084e3b2dffd5de6b7b16cee7969282de7");
```

**Obtain the list of unconfirmed transactions in memory.**

```php
$neo->getRawMemPool();
```

**Returns the corresponding transaction information, based on the specified hash value.**

```php
$neo->getRawTransaction("602c79718b16e442de58778e148d0b1084e3b2dffd5de6b7b16cee7969282de7",true);
```

**Query contract information, according to the contract script hash.**

```php
$neo->getStorage("c56f33fc6ecfcd0c225c4ab356fee59390af8560be0e930faebe74a6daff7c9b");
```

**Returns the corresponding transaction output information (returned change), based on the specified hash and index.**

```php
$neo->getTxOut("0e3c0f477d80acda1c45650b3260e2410287ef78c291f6e02f0214daca2bd2cf",0);
```

**Broadcasts a transaction over the NEO network. There are many kinds of transactions, as specified in the network protocol [documentation](http://docs.neo.org/en-us/node/network-protocol.html)**
```php
$transaction_id = ""; //A hexadecimal string that has been serialized, after the signed transaction in the program.
$broadcastTransaction = $neo->sendRawTransaction($transaction_id);
if ($broadcastTransaction)
	echo "Sent";
else
	echo "Hasn't been sent";
```

**Validate an address**
```php
if ($neo->validateAddress("AXCLjFvfi47R1sKLrebbRJnqWgbcsncfro"))
	echo "Address is valid";
else
	echo "Address is not valid";
```

Be kind and credit me ❤️.

Check out [Neodius](https://github.com/ITSVision/Neodius)

Licensed under [MIT License](License)

Enjoy!
