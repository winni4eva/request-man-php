# request-man-php
A php http request library 

# composer autoloading
require_once __DIR__ . "/vendor/autoload.php";

# import RequestMan class
use RequestMan\RequestMan;

# making a request 
# set url
# set client (curl or guzzle)
# methods can be chained
$url = "https://jsonplaceholder.typicode.com/posts";

$response = RequestMan::setUrl( $url )->setClient('cUrL')->fire();

# get raw data
var_dump($response->toRaw());

# convert response to a laravel collection https://laravel.com/docs/5.3/collections
var_dump($response->toCollection());

# convert response to array
var_dump($response->toCollection()->toArray());

# get status code
echo 'Status Code : '. RequestMan::getStatusCode() .'<br>';

# get content type
echo 'Content Type : '. RequestMan::getContentType() .'<br>';
