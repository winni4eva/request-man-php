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
        if(!self::$requestUrl) throw new Exception("No request url set");
        $clientName = ucfirst( strtolower( self::$requestClient ) );
        $client = "RequestMan\Clients\{$clientName}\{$clientName}Client";
        self::$client = new $client;
    }

    public function send(){

        self::$response = self::$client->request();

        return new static( self::$response );
        
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

    public function getStatusCode()
    {
        if(!is_object(self::$client)) throw new Exception("You need to make a request from which a status code will be generated"); 

        return self::$client::$http_status_code;
    }

    public function getContentType()
    {
        if(!is_object(self::$client)) throw new Exception("You need to make a request from which a content type will be generated"); 

        return self::$client::$content_type;
    }

    public static function setClient($client)
    {
        $client = strtoupper (strtolower( $client ) );

        if( ! collect( self::$supportedClients )->contains( $client ) ) 
            throw new Exception("Client value should be ". implode(' , ',self::$supportedClients));

        self::$requestClient = $client;

        return new static;
    }

    public static function setUrl($url)
    {
        self::$requestUrl = $url;

        return new static;
    }

}