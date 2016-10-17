<?php
namespace RequestMan;

abstract class AbstractRequest{
    
    public static $endpoint;

    public static $agent = "Mozilla/5.0 (Windows NT 6.1; rv:19.0) Gecko/20100101 executefox/19.0";

    public static $response;

    public static $http_status_code;

    public static $content_type;

    public static $method;

    public static $post;

}