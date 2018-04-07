<?php
include("../vendor/autoload.php");

//setup coinmarketcap object
$cmcObject = new \NeoPHP\CoinMarketCap();

//set currency, if not set default to EUR
$cmcObject->setCurrency("EUR");

//get top100 ticker
print_r($cmcObject->getTicker());

//get ticket for asset GAS
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_GAS));
//get ticket for asset NEO
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_NEO));
//get ticket for asset TKY
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_TKY));
//get ticket for asset ONT
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_ONT));
//get ticket for asset ACAT
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_ACAT));
//get ticket for asset NRVE
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_NRVE));
//get ticket for asset RPX
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_RPX));
//get ticket for asset DBC
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_DBC));
//get ticket for asset TNC
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_TNC));
//get ticket for asset ZPT
print_r($cmcObject->getTickerForAsset(\NeoPHP\Assets\NeoAssets::ASSET_ZPT));


//get global data
print_r($cmcObject->getGlobalData());
