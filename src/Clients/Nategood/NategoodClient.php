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

        $res = \Httpful\Request::get(self::$endpoint)
                                        //->expectsJson()
                                        //->withXTrivialHeader('Just as a demo')
                                        ->sendIt();
        
        parent::$content_type = $res->contentType();

        //parent::$http_status_code = $res->getStatusCode();

        return parent::$response = $res->body;
    
    }

    public function getClient(){
        return self::$nateGood;
    }

}