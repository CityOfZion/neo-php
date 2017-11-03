# PHPNeo
A NEO RPC wrapper in PHP

## A Lot work in progress :)

**Connecting**
```$neo = new PHPNeo();
//$neo->setNode($neo->getFastestNode());
$neo->setNode("http://seed5.neo.org:10332");```


**Query the account asset information, according to the account address.**

```$neo->getAccountState($testAddress)```

**Query the asset information, based on the specified asset number.**

```$neo->getAssetState($neoAssetID)```;

**Returns the hash of the tallest block in the main chain.**

```$neo->getBestBlockHash();```

**Returns the corresponding block information according to the specified index OR hash.**
```$neo->getBlock("0x56adb8cc0de3e4fff7b8641988c83bfca214802d263495403055efdd437234c4");
$neo->getBlock(1533325);```

**Gets the number of blocks in the main chain.**

```$neo->getBlockCount();```

**not sure what this does :-)**

```$neo->getBlockSysFee($neo->getBlockCount()-1);```

**Returns the hash value of the corresponding block, based on the specified index.**

```$neo->getBlockHash($neo->getBlockCount()-1);```

**Gets the current number of connections for the node.**

```$neo->getConnectionCount();```

Be kind and credit me ❤️.

Check out [Neodius](https://github.com/ITSVision/Neodius)

Licensed under [MIT License](License)

Enjoy!
