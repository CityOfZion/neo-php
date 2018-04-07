<?php
namespace NeoPHP;

use NeoPHP\Tools\NetworkRequest;
use NeoPHP\Assets\NeoAssets;

/**
 * Class NeoRPC
 *
 * @package PHPNeo
 */
class CoinMarketCap
{
    const DEFAULT_CURRENCY = "USD";

    /**
     * arrAvailableCurrencies
     *
     * @var mixed
     * @access private
     */
    private $arrAvailableCurrencies = array(
        "AUD", "BRL", "CAD", "CHF", "CLP",
        "CNY", "CZK", "DKK", "EUR", "GBP",
        "HKD", "HUF", "IDR", "ILS", "INR",
        "JPY", "KRW", "MXN", "MYR", "NOK",
        "NZD", "PHP", "PKR", "PLN", "RUB",
        "SEK", "SGD", "THB", "TRY", "TWD",
        "ZAR"
    );
    
    
    /**
     * currency
     *
     * @var mixed
     * @access private
     */
    private $currency;
    
    
    /**
     * endPint
     *
     * @var mixed
     * @access private
     */
    private $endPint;

    /**
     * __construct function.
     *
     * @access public
     * @param mixed $defaultCurrency
     * @return void
     */
    public function __construct()
    {
        $this->setCurrency(self::DEFAULT_CURRENCY);
        $this->endPoint = "https://api.coinmarketcap.com/v1/";
    }
    
    /**
     * setCurrency function.
     *
     * @access public
     * @param mixed $currency
     * @return mixed
     */
    public function setCurrency($currency)
    {
        if (in_array($currency, $this->arrAvailableCurrencies));
        return $this->currency = $currency;
        return false;
    }
    
    /**
     * getTicker function.
     *
     * @access public
     * @param int $start (default: 0)
     * @param int $limit (default: 100)
     * @return mixed
     */
    public function getTicker($start=0, $limit=100)
    {
        //create new network request
        $r = new NetworkRequest();
        return $r->get($this->endPoint."ticker/", [
            "convert"=>$this->currency,
            "start"=>$start,
            "limit"=>$limit
        ]);
    }
    
    /**
     * getTickerForAsset function.
     *
     * @access public
     * @param mixed $asset
     * @return mixed
     */
    public function getTickerForAsset($asset)
    {
        if (!$assetCmcId = NeoAssets::getCoinMarketCapId($asset)) {
            return [];
        }

        //create new network request
        $r = new NetworkRequest();
        return $r->get($this->endPoint."ticker/{$assetCmcId}/", [
            "convert"=>$this->currency,
        ])[0];
    }
    
    /**
     * getGlobalData function.
     *
     * @access public
     * @return mixed
     */
    public function getGlobalData()
    {
        //create new network request
        $r = new NetworkRequest();
        return $r->get($this->endPoint."global/", [
            "convert"=>$this->currency,
        ]);
    }
}
