<?php

namespace RequestMan\Clients\Curl;

use RequestMan\AbstractRequest;
use RequestMan\RequestInterface;
use RequestMan\RequestTrait;

class CurlClient extends AbstractRequest implements RequestInterface{

    use RequestTrait;
    
    protected $returnTransfer; 

    protected $followLocation; 

    protected $timeout; 

    protected $header;

    public function __construct(
                                $url, 
                                array $headers = [],
                                array $options = [],  
                                $method = 'GET', 
                                array $post = []
                                )
    {
        parent::$endpoint = $url;
        parent::$method = $method;
        parent::$post = $post;
        parent::$headers = $headers;
        parent::$options = $options;
    }

    private function execute(){

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => parent::$endpoint,
            CURLOPT_RETURNTRANSFER => array_key_exists('returnTransfer', parent::$options)? parent::$options['returnTransfer'] : true,
            CURLOPT_USERAGENT => parent::$agent,
            CURLOPT_FOLLOWLOCATION => array_key_exists('followLocation', parent::$options)? parent::$options['followLocation'] : true,
            CURLOPT_TIMEOUT => array_key_exists('timeout', parent::$options)? parent::$options['timeout'] : 1000,
            //CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_HEADER => array_key_exists('header', parent::$options)? parent::$options['header'] : false,
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