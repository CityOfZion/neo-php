# neo-php
This project aims to be a full Neo implementation written in PHP.

## Work in progress. Frequently updated. Use at your own discretion!

The NeoPHP package and its contributors are not responsible for any damages or lost funds.

# Installation
```
composer require --prefer-dist neo-php/neo-php "dev-master"
```

# Functioning features

## Wallet functions
There are a couple of wallet functions:

### Wallet initializers

**Create new wallet**
```php
$newWallet = new NeoPHP\NeoWallet();
```

**Open current wallet**
```php
$wallet = new NeoPHP\NeoWallet("KzfUdP9MbsuL4Ejo1rTWve4JZfa7m1hc397JGXTHhNqJDAqMxZYu");
```

**Create new encrypted wallet**
```php
$wallet = new NeoPHP\NeoWallet();
$wallet->encryptWallet("passphrase");
```

**Open an encrypted wallet**
```php
$wallet = new NeoPHP\NeoWallet("6PYMFa9gMAcBrTaAs8JyDrtoGLqb45P8dnmUfVVNcfLd9xKUdffSNfKWKp","passphrase");
```

**Encrypt an existing wallet**
```php
$wallet = new NeoPHP\NeoWallet("KzfUdP9MbsuL4Ejo1rTWve4JZfa7m1hc397JGXTHhNqJDAqMxZYu");
$wallet->encryptWallet("passphrase");
```

### Wallet properties
The wallet properties are currently:

```php
# BOOL is $wallet and encrypted wallet
$wallet->isNEP2();

# String get the encrypted address, when isNEP2()
$wallet->getEncryptedKey();

# String get wif for initialized $wallet
$wallet->getWif();

# String get address for initialized $wallet
$wallet->getAddress();

# String get key for initialized $wallet
$wallet->getPrivateKey()
```

### The future
For now you can open wallets, get the private key, public key, wif, etc. You can also see if the wallet is encrypted. The future plans are that you can do transactions and invoke smart contracts.

[There are a lot of examples](https://github.com/ITSVision/neo-php/tree/master/examples/)

### NEO Cold wallet generator
You can also run the [cli-create-wallet-interactive.php](https://github.com/ITSVision/neo-php/blob/master/examples/cli-create-wallet-interactive.php) example to generate a new wallet. You can do so on a fresh virtual and disconnected Linux distro, you can do a clean run and keep your wallet safe.

## The RPC

**Connecting to a RPC Node**
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
$neo->getStorage("c56f33fc6ecfcd0c225c4ab356fee59390af8560be0e930faebe74a6daff7c9b", "74657374");
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

# Created by
* **Benjamin de Bos** ([LinkedIn](https://www.linkedin.com/in/benjamindebos/)) - [Nodius (NEO Blockchain App)](https://github.com/ITSVision/Nodius) & [ITSVision](https://github.com/ITSVision)

* **Dean van Dugteren** ([LinkedIn](https://www.linkedin.com/in/deanpress/)) - [NEO dApp Starter Kit](https://github.com/deanpress/neo-dapp-starter-kit), [Vidiato](https://vidiato.com), [Click.DJ](https://click.dj)

Check out [Nodius](https://github.com/ITSVision/Nodius)

Licensed under [MIT License](License)

Enjoy!
