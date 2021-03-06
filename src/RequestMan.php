<?php
namespace RequestMan;

use RequestMan\Clients\Curl\CurlClient;
use RequestMan\Clients\Guzzle\GuzzleClient;
use RequestMan\Clients\NateGood\NateGoodClient;
use Exception;

class RequestMan
{

    private static $client;

    private static $response;

    private static $requestClient = 'CURL';

    private static $supportedClients = ['CURL','GUZZLE','NATEGOOD'];

    private static $requestUrl = '';

    private static $headers = [];

    private static $options = [];

    private static $method = 'GET';

    private static $post = [];


    public function send()
    {

        if(!self::$requestUrl) throw new Exception("No request url set");

        $this->buildRequestClient();

        self::$response = self::$client->request();

        return new static( self::$response );
        
    }

    public function toCollection()
    {
        return collect ( self::jsonToArray() );
    }

    public function toRaw(){
        return self::$response;
    }

    public function jsonToArray()
    {
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

    public static function setHeaders(array $headers = [])
    {
        self::$headers = $headers;

        return new static;
    }

    public static function setOptions(array $options = [])
    {
        self::$options = $options;

        return new static;
    }

    public static function setMethod($method = 'GET')
    {
        self::$method = $method;

        return new static;
    }

    public static function setPost(array $post = [])
    {
        self::$post = $post;

        return new static;
    }

    private function buildRequestClient()
    {
        $clientName = ucfirst( strtolower( self::$requestClient ) );

        $client = "RequestMan\\Clients\\{$clientName}\\{$clientName}Client";

        self::$client = new $client(self::$requestUrl, self::$headers, self::$options, self::$method, self::$post);
    }

}