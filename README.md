# request-man-php
A php http request library 

# composer autoloading
require_once __DIR__ . "/vendor/autoload.php";

# import RequestMan class
use RequestMan\RequestMan;

# making a request 
$url = "https://jsonplaceholder.typicode.com/posts";

$response = RequestMan::setUrl( $url )->setClient('cUrL')->fire();

supported clients => curl / guzzle

# get raw data
var_dump($response->toRaw());

# convert response to a laravel collection 
var_dump($response->toCollection());
visit https://laravel.com/docs/5.3/collections for more details

# convert response to array
var_dump($response->toCollection()->toArray());

# get status code
echo 'Status Code : '. RequestMan::getStatusCode() .'<br>';

# get content type
echo 'Content Type : '. RequestMan::getContentType() .'<br>';
