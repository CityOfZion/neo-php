<?php
include("../../../../vendor/autoload.php");

use \NeoPHP\NeoNEP5;
use \NeoPHP\Assets\NeoAssets;

#test net or not
$rpcObject = new \NeoPHP\NeoRPC(true);
#$rpcObject->setNode($rpcObject->getFastestNode());
$rpcObject->setNode("https://seed1.redpulse.com:10331");

//get the NEP5 token balance for TKY
print_r("ZPT Balance: ".NeoNEP5::getTokenBalance($rpcObject, NeoAssets::ASSET_TKY, "AJghWoGBa1D1XskAjGY3969MgCeGhMwR8e")."\n");

//get the NEP5 token balance for ZPT
print_r("ZPT Balance: ".NeoNEP5::getTokenBalance($rpcObject, NeoAssets::ASSET_ZPT, "AKDVzYGLczmykdtRaejgvWeZrvdkVEvQ1X")."\n");
