<?php

namespace RequestMan\Clients\Guzzle;

use RequestMan\AbstractRequest;
use RequestMan\RequestInterface;
use GuzzleHttp\Client;

class GuzzleClient extends AbstractRequest implements RequestInterface{

    protected static $guzzle;

    public function __construct($url, $method = 'GET', array $post = []){
        parent::$endpoint = $url;
        parent::$method = $method;
        parent::$post = $post;
        self::$guzzle = new Client;
    }

    public static function request(){

         return (new self(self::$endpoint))->execute();
    }

    private function execute(){

        $res = self::$guzzle->request(self::$method, self::$endpoint);

        self::$http_status_code = $res->getStatusCode();
        
        self::$content_type = $res->getHeaderLine('content-type');
        
        return parent::$response = $res->getBody();
    
    }

    public function getClient(){
        return self::$guzzle;
    }

}