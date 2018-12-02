<p align="center">
  <img
    src="http://res.cloudinary.com/vidsy/image/upload/v1503160820/CoZ_Icon_DARKBLUE_200x178px_oq0gxm.png"
    width="125px;">
</p>

<h1 align="center">neo-php</h1>
<p align="center">
	PHP SDK for the NEO blockchain. 
</p>


## Overview

### What does it currently do
- Installation though Composer
- Open, create and encrypt unencrypted wallets
- Create and open encrypted wallet
- Minimal NEP-5 interation (token balance requesting and Smart Contract parameter factory)
- All RPC functions are integrated. 
- Address validation
- It contains a cold wallet generator
- Coinmarketcap API integration

### What will (should) it do
- Do wallet transactions for: NEO, GAS and NEP-5 Tokens
- Build, deploy, and run smart contracts
- A lot more

### Documentation
Currently there isn't much documentation besides this Readme. We could use it! Do a PR if you'd like to help us :). [Though there are a lot of examples](https://github.com/CityOfZion/neo-php/tree/master/examples/)

### Get help or give help

- Open a new [issue](https://github.com/CityOfZion/neo-php/issues/new) if you encounter a problem.
- Or ping **@Deanpress**  or **@Woodehh** on the [NEO Discord](https://discord.gg/R8v48YA).
- Pull requests welcome. You can help with wallet functionality, writing tests
  or documentation, or on any other feature you deem awesome.

## Getting started
To start using neo-php you need to have [composer](https://getcomposer.org/) installed. When you're ready openup a terminal and type in:
```
composer require cityofzion/neo-php @dev
```
From there on include the autoloader and you can use all of the juicy neo-php features.

### Wallet functionality:
The wallet part of neo-php consists out of initializers that have multiple functions.

**Create new unencrypted wallet**
```php
$newWallet = new NeoPHP\NeoWallet();
```

**Open an unencrypted wallet**
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

**BOOL to test if wallet is an encrypted wallet**
```php
$wallet->isNEP2();
```

**String get the encrypted address, when isNEP2()**
```php
$wallet->getEncryptedKey();
```

**String get wif for initialized wallet**
```php
$wallet->getWif();
```

**String get address for initialized wallet**
```php
$wallet->getAddress();
```

**String get key for initialized wallet**
```php
$wallet->getPrivateKey()
```

### Minimal NEP-5 integration
We're working on NEP5 integration. For now we're able to request the majority of the NEP5 tokens balance with a specified address.

**Requesting NEP-5 Token balance for address**
```php
$rpcObject = new NeoRPC();
$rpcObject->setNode("https://seed1.redpulse.com:10331");
\NeoPHP\NEP5::getTokenBalance($rpcObject,NeoPHP\NeoAssets::ASSET_ZPT,"AKDVzYGLczmykdtRaejgvWeZrvdkVEvQ1X");
\NeoPHP\NEP5::getTokenBalance($rpcObject,NeoPHP\NeoAssets::ASSET_TKY,"AKDVzYGLczmykdtRaejgvWeZrvdkVEvQ1X")
```

**Right now we have the following "assets" which you can request the balance for:**

<table>
	<tr>
		<th>Token</th>
		<th>Asset constant</th>
	</tr>
	<tr>
		<td>Ontology</td>
		<td>NeoPHP\NeoAssets::ASSET_ONT</td>
	</tr>
	<tr>
		<td>THEKEY</td>
		<td>NeoPHP\NeoAssets::ASSET_TKY</td>
	</tr>
	<tr>
		<td>Congierce token</td>
		<td>NeoPHP\NeoAssets::ASSET_CGE</td>
	</tr>		
	<tr>
		<td>Alphacat</td>
		<td>NeoPHP\NeoAssets::ASSET_ACAT</td>
	</tr>		
	<tr>
		<td>Narrative Token</td>
		<td>NeoPHP\NeoAssets::ASSET_NRVE</td>
	</tr>
	<tr>
		<td>Red Pulse</td>
		<td>NeoPHP\NeoAssets::ASSET_RPX</td>
	</tr>
	<tr>
		<td>DeepBrainChain</td>
		<td>NeoPHP\NeoAssets::ASSET_DBC</td>
	</tr>
	<tr>
		<td>QLink</td>
		<td>NeoPHP\NeoAssets::ASSET_QLC</td>
	</tr>
	<tr>
		<td>Trinity Network Credit</td>
		<td>NeoPHP\NeoAssets::ASSET_TN</td>
	</tr>
	<tr>
		<td>Zeepin Token</td>
		<td>NeoPHP\NeoAssets::ASSET_ZPT</td>
	</tr>
	<tr>
		<td>PikcioChain</td>
		<td>NeoPHP\NeoAssets::ASSET_PKC</td>
	</tr>
</table>

### The RPC
The RPC is the way to talk to the different blockchain nodes. For example: We use it to request the balance for the NEP-5 tokens.

**Connecting to a RPC Node**
```php
$neo = new NeoRPC(); #use false as argument to go to testnet
//$neo->setNode($neo->getFastestNode());
$neo->setNode("http://seed5.neo.org:10332");
```

**Asking for balance using the CityOfZion API**

```php
$neo->getBalance($testAddress);
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

### NEO Cold wallet generator
You can also run the [cli-create-wallet-interactive.php](https://github.com/ITSVision/neo-php/blob/master/examples/cli-create-wallet-interactive.php) example to generate a new wallet. You can do so on a fresh virtual and disconnected Linux distro, you can do a clean run and keep your wallet safe.

### CoinMarketCap integration
Neo-PHP Features a full CoinMarketCap API integration. 

**To initiate the object**
```php
//setup coinmarketcap object
$cmcObject = new \NeoPHP\CoinMarketCap();

//set currency, if not set it defaults to USD
$cmcObject->setCurrency("EUR");
```

**To request the ticker**
```php
print_r($cmcObject->getTicker());
```
Arguments are start and limit. Similar to MySQL start and limit

**To request the ticker for a specific currency**
```php
//get ticket for asset GAS
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_GAS));
//get ticket for asset NEO
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_NEO));
```
[Check NEP-5 asset constants of this documentation for the right assets](#minimal-nep-5-integration)

**To get global data**
```php
//get global data
print_r($cmcObject->getGlobalData());
```
[Check NEP-5 asset constants of this documentation for the right assets](#minimal-nep-5-integration)

# Created by
* **Benjamin de Bos** ([LinkedIn](https://www.linkedin.com/in/benjamindebos/)) - [Neodius (NEO Blockchain App)](https://github.com/Cityofzion/Neodius) & [ITSVision](https://github.com/ITSVision)

* **Dean van Dugteren** ([LinkedIn](https://www.linkedin.com/in/deanpress/)) - [NEO dApp Starter Kit](https://github.com/deanpress/neo-dapp-starter-kit), [Vidiato](https://vidiato.com), [Click.DJ](https://click.dj)

Check out [Neodius](https://github.com/ITSVision/Nodius)

Licensed under [MIT License](License)

Enjoy!
