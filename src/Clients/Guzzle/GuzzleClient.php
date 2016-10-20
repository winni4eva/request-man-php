<?php

namespace RequestMan\Clients\Guzzle;

use RequestMan\AbstractRequest;
use RequestMan\RequestInterface;
use RequestMan\RequestTrait;
use GuzzleHttp\Client;

class GuzzleClient extends AbstractRequest implements RequestInterface{

    use RequestTrait;
    
    protected static $guzzle;

    public function __construct($url, $method = 'GET', array $post = []){
        parent::$endpoint = $url;
        parent::$method = $method;
        parent::$post = $post;
        self::$guzzle = new Client;
    }

    private function execute(){

        $res = self::$guzzle->request(parent::$method, parent::$endpoint);

        parent::$http_status_code = $res->getStatusCode();
        
        parent::$content_type = $res->getHeaderLine('content-type');
        
        return parent::$response = $res->getBody()->getContents();
    
    }

    public function getClient(){
        return self::$guzzle;
    }

}