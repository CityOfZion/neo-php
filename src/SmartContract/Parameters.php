<?php
namespace NeoPHP\SmartContract;

class Parameters
{
    const PARAMETER_ADDRESS   = 0,
          PARAMETER_STRING	  = 1,
          PARAMETER_BOOLEAN	  = 2,
          PARAMETER_HASH160	  = 3,
          PARAMETER_INTEGER	  = 4;

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->parameters = [];
    }
    
    
    /**
     * getParameters function.
     *
     * @access public
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }
    
    
    /**
     * addParameter function.
     *
     * @access public
     * @param mixed $type
     * @param mixed $value
     * @return Parameters
     */
    public function addParameter($type, $value)
    {
        if ($type == self::PARAMETER_ADDRESS) {
            $this->addByteParameter($value, "address");
        } elseif ($type == self::PARAMETER_STRING) {
            $this->addStringParameter($value);
        } elseif ($type == self::PARAMETER_BOOLEAN) {
            $this->addBooleanParameter($value);
        } elseif ($type == self::PARAMETER_HASH160) {
            $this->addHash160Parameter($value);
        } elseif ($type == self::PARAMETER_INTEGER) {
            $this->addIntegerParameter($value);
        }
        
        return $this;
    }
    
    /**
     * addStringParameter function.
     *
     * @access private
     * @param mixed $value
     * @return void
     */
    private function addStringParameter($value)
    {
        $this->parameters[] = [
            "type" => "String",
            "value" => $value,
        ];
    }

    /**
     * addBooleanParameter function.
     *
     * @access private
     * @param mixed $value
     * @return void
     */
    private function addBooleanParameter($value)
    {
        $this->parameters[] = [
            "type" => "Boolean",
            "value" => $value,
        ];
    }

    /**
     * addHash160Parameter function.
     *
     * @access private
     * @param mixed $value
     * @return void
     */
    private function addHash160Parameter($value)
    {
        $this->parameters[] = [
            "type" => "Hash160",
            "value" => $value,
        ];
    }

    /**
     * addIntegerParameter function.
     *
     * @access private
     * @param mixed $value
     * @return void
     */
    private function addIntegerParameter($value)
    {
        $this->parameters[] = [
            "type" => "Integer",
            "value" => $value,
        ];
    }
    
    /**
     * addByteParameter function.
     *
     * @access private
     * @param mixed $value
     * @param mixed $format
     * @return void
     */
    private function addByteParameter($value, $format)
    {
        if ($format) {
            $format = strtolower($format);
        }

        //create the scripthash
        $scriptHash = \NeoPHP\Crypto\WIF::getScriptHashFromAddress($value);
        //reverse the hex and bring back as bytearray
        $reverseHex = \NeoPHP\Tools\StringTools::reverseHex($scriptHash);
        
        $this->parameters[] = [
            "type" => "ByteArray",
            "value" => $reverseHex
        ];
    }
}
