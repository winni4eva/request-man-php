<?php

namespace RequestMan\Clients\Nategood;

use RequestMan\AbstractRequest;
use RequestMan\RequestInterface;
use RequestMan\RequestTrait;
use Httpful\Request;

class NategoodClient extends AbstractRequest implements RequestInterface{

    use RequestTrait;

    protected static $nateGood;

    public function __construct($url, $method = 'GET', array $post = [], array $headers = []){
        parent::$endpoint = $url;
        parent::$method = $method;
        parent::$post = $post;
        parent::$headers = $headers;
        //self::$nateGood = new Request;
    }

    private function execute(){

        // $res = self::$guzzle->request(self::$method, self::$endpoint);

        // self::$http_status_code = $res->getStatusCode();
        
        // self::$content_type = $res->getHeaderLine('content-type');
        
        // return parent::$response = $res->getBody();

        $res = \Httpful\Request::get("https://api.github.com/users/nategood")
                                        ->expectsJson()
                                        ->withXTrivialHeader('Just as a demo')
                                        ->sendIt();

        return parent::$response = $res->body;
    
    }

    public function getClient(){
        return self::$nateGood;
    }

}