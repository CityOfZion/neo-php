<?php
namespace NeoPHP\Tools;

class NetworkRequest
{
    
    /**
     * curl
     *
     * @var mixed
     * @access private
     */
    private $curl;
    
    /**
     * headers
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $headers = array();
    
    /**
     * options
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $options = array();
    
    /**
     * result
     *
     * @var mixed
     * @access private
     */
    private $rawResult;
    
    
    /**
     * errorCode
     *
     * @var mixed
     * @access private
     */
    private $errorCode;
    
    /**
     * errorMessage
     *
     * @var mixed
     * @access private
     */
    private $errorMessage;
    
    
    /**
     * curlError
     *
     * @var mixed
     * @access private
     */
    private $curlError;
    
    /**
     * agent
     *
     * @var mixed
     * @access private
     */
    private $agent;
    
    
    /**
     * url
     *
     * @var mixed
     * @access private
     */
    private $url;
    
    
    /**
     * getInfo
     *
     * @var mixed
     * @access private
     */
    private $getInfo;
    
    
    /**
     * isJson
     *
     * @var mixed
     * @access private
     */
    private $isJson;
    
    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        
        //setup curl object
        $this->curl = curl_init();
        
        $this->setOpt(CURLOPT_RETURNTRANSFER, 1);
        $this->setOpt(CURLOPT_USERAGENT, "cURL Class");
    }
    
    /**
     * get function.
     *
     * @access public
     * @param mixed $url
     * @param bool $params (default: false)
     * @return void
     */
    public function get($url, $params = false)
    {
    
        //set url
        $this->setUrl($url."?".http_build_query($params));

        //set opt
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'GET');
        $this->setOpt(CURLOPT_HTTPGET, true);

        //return exec command
        return $this->exec();
    }

    /**
     * get function.
     *
     * @access public
     * @param mixed $url
     * @param bool $params (default: false)
     * @return void
     */
    public function post($url, $params = false)
    {
    
        //set url
        $this->setUrl($url);

        //set opt
        $this->setOpt(CURLOPT_POST, 1);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'POST');
        $this->setOpt(CURLOPT_POSTFIELDS, $params);

        //return exec command
        return $this->exec();
    }
    
    
    /**
     * setHeader function.
     *
     * @access public
     * @param mixed $header
     * @return void
     */
    public function setHeader($header)
    {
        $this->headers[] = $header;
    }
    
    /**
     * setHeaders function.
     *
     * @access public
     * @param mixed $headers
     * @return void
     */
    public function setHeaders($headers)
    {
        foreach ($headers as $header) {
            $this->headers[] = $header;
        }
    }
    
    /**
     * setAgent function.
     *
     * @access public
     * @param mixed $agent
     * @return void
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    }
    
    /**
     * setOpt function.
     *
     * @access public
     * @param mixed $opt
     * @param mixed $val
     * @return void
     */
    public function setOpt($opt, $val)
    {
        curl_setopt($this->curl, $opt, $val);
    }
    
    /**
     * setOpts function.
     *
     * @access public
     * @param mixed $options
     * @return void
     */
    public function setOpts($options)
    {
        foreach ($options as $opt => $val) {
            $this->setOpt($opt, $val);
        }
        return true;
    }
    
    /**
     * exec function.
     *
     * @access public
     * @return void
     */
    public function exec()
    {
        
        //set headers:
        $this->setOpt(CURLOPT_HTTPHEADER, $this->headers);
        
        $this->rawResponse = curl_exec($this->curl);
        $this->curlErrorCode = curl_errno($this->curl);
        $this->curlErrorMessage = curl_error($this->curl);
        $this->curlError = !($this->curlErrorCode === 0);
        $this->getInfo = curl_getinfo($this->curl);

        if (!$this->curlError) {
            if ($json = $this->checkIfJson($this->rawResponse)) {
                $this->isJson = true;
                return $json;
            } else {
                $this->isJson = false;
                return $this->rawResponse;
            }
        } else {
            return false;
        }
    }
    
    /**
     * getInfo function.
     *
     * @access public
     * @return void
     */
    public function getInfo()
    {
        return $this->getInfo;
    }
    
    /**
     * getErrorCode function.
     *
     * @access public
     * @return void
     */
    public function getErrorCode()
    {
        return $this->curlErrorCode;
    }

    /**
     * getErrorCode function.
     *
     * @access public
     * @return void
     */
    public function getErrorMessage()
    {
        return $this->curlErrorMessage;
    }
    
    /**
     * setUrl function.
     *
     * @access private
     * @param mixed $url
     * @return void
     */
    private function setUrl($url)
    {
        $this->url = $url;
        $this->setOpt(CURLOPT_URL, $url);
    }
    
    /**
     * isJson function.
     *
     * @access private
     * @param mixed $string
     * @return void
     */
    private function checkIfJson($string)
    {
        $r = json_decode($string, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            return $r;
        }
        return false;
    }
    
    public function isjson()
    {
        return $this->isJson;
    }
}
