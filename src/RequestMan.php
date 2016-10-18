<?php
namespace RequestMan;

use RequestMan\Clients\Curl\CurlClient;
use RequestMan\Clients\Guzzle\GuzzleClient;
//use RequestMan\Clients\NateGood\NateGoodClient;
use Exception;

class RequestMan
{

    private static $client;

    private static $response;

    private static $requestClient = 'CURL';

    private static $supportedClients = ['CURL','GUZZLE'];

    private static $requestUrl;

    protected function __construct(){
        if(!self::$requestUrl) throw new Exception("No request url set", 401);

        if(self::$requestClient == 'CURL'){
            self::$client = new CurlClient(self::$requestUrl);
        }elseif(self::$requestClient == 'GUZZLE'){
            self::$client = new GuzzleClient(self::$requestUrl);
        }elseif(self::$requestClient == 'NATEGOOD'){
            //self::$client = new NateGoodClient(self::$requestUrl);
        }
    }

    public function send(){

        self::$response = self::$client->request();
        
        //if( self::statusCode() == 200 ) 
        return new static( self::$response );
        
        //throw new Exception("Error Processing Request : Status Code => {self::$client::$http_status_code} : Content Type => {self::$client::$content_type}", 401);
    }

    public function toCollection(){
        return collect ( self::jsonToArray() );
    }

    public function toRaw(){
        return self::$response;
    }

    public function jsonToArray(){
        return json_decode( self::$response, true );
    }

    public function getStatusCode(){
        if(!is_object(self::$client)) throw new Exception("You need to make a request from which a status code will be generated", 401); 
        return self::$client::$http_status_code;
    }

    public function getContentType(){
        if(!is_object(self::$client)) throw new Exception("You need to make a request from which a content type will be generated", 401); 
        return self::$client::$content_type;
    }

    public static function setClient($client){
        $client = strtoupper (strtolower( $client ) );
        if( ! collect( self::$supportedClients )->contains( $client ) ) throw new Exception("Client value should be ". implode(' , ',self::$supportedClients), 401);
        self::$requestClient = $client;
        return new static('');
    }

    public static function setUrl($url){
        self::$requestUrl = $url;
        return new static('');
    }

}