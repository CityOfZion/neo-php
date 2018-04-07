<?php
include("../vendor/autoload.php");

#test net or not
$rpcObject = new \NeoPHP\NeoRPC(true);
#$rpcObject->setNode($rpcObject->getFastestNode());
$rpcObject->setNode("https://seed1.redpulse.com:10331");

//get the NEP5 token balance for TKY
print_r("ZPT Balance: ".\NeoPHP\NeoNEP5::getTokenBalance($rpcObject, \NeoPHP\Assets\NeoAssets::ASSET_TKY, "AJghWoGBa1D1XskAjGY3969MgCeGhMwR8e")."\n");

//get the NEP5 token balance for ZPT
print_r("ZPT Balance: ".\NeoPHP\NeoNEP5::getTokenBalance($rpcObject, NeoPHP\NeoAssets::ASSET_ZPT, "AKDVzYGLczmykdtRaejgvWeZrvdkVEvQ1X")."\n");
