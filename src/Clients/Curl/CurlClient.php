<?php

namespace RequestMan\Clients\Curl;

use RequestMan\AbstractRequest;
use RequestMan\RequestInterface;

class CurlClient extends AbstractRequest implements RequestInterface{

    protected $returnTransfer; 

    protected $followLocation; 

    protected $timeout; 

    protected $header;

    public function __construct($url, $method = 'GET', $post = [], $returnTransfer = true, $followLocation = true, $timeout = 1000, $header = false){
        
        parent::$endpoint = $url;

        parent::$method = $method;

        parent::$post = $post;

        $this->returnTransfer = $returnTransfer;

        $this->followLocation = $followLocation;

        $this->timeout = $timeout;

        $this->header = $header;
    }

    public static function request( ){
        return (new self(parent::$endpoint))->execute();
    }

    private function execute(){

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => parent::$endpoint,
            CURLOPT_RETURNTRANSFER => $this->returnTransfer,
            CURLOPT_USERAGENT => $this->agent,
            CURLOPT_FOLLOWLOCATION => $this->followLocation,
            CURLOPT_TIMEOUT => $this->timeout,
            //CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_HEADER => $this->header,
            CURLOPT_POST => (strtoupper(parent::$method) == 'GET')? 0 : 1,
            CURLOPT_POSTFIELDS => parent::$post
        ]);

        parent::$response = curl_exec($ch);

        parent::$http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        parent::$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        return parent::$response;
    
    }

}