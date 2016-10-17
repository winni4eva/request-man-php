<?php

namespace RequestMan\Clients\NateGood;

use RequestMan\AbstractRequest;
use RequestMan\RequestInterface;
use Httpful\Request;

class NateGoodClient extends AbstractRequest implements RequestInterface{

    protected static $nateGood;

    public function __construct($url, $method = 'GET', array $post = []){
        parent::$endpoint = $url;
        parent::$method = $method;
        parent::$post = $post;
        //self::$nateGood = new Request;
    }

    public static function request(){

         return (new self(self::$endpoint))->execute();
    }

    private function execute(){

        // $res = self::$guzzle->request(self::$method, self::$endpoint);

        // self::$http_status_code = $res->getStatusCode();
        
        // self::$content_type = $res->getHeaderLine('content-type');
        
        // return parent::$response = $res->getBody();

        $res = Request::get(self::$endpoint)
                                        //->expectsJson()
                                        //->withXTrivialHeader('Just as a demo')
                                        ->sendIt();

        return parent::$response = $res->body;
    
    }

    public function getClient(){
        //return self::$guzzle;
    }

}