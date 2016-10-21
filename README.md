# request-man-php
A php http request library 

# composer autoloading
require_once __DIR__ . "/vendor/autoload.php";

# import RequestMan class
use RequestMan\RequestMan;

# making a request 
$url = "https://jsonplaceholder.typicode.com/posts";

$response = RequestMan::setUrl( $url )->setClient('guzzle')->send();

# get raw data
var_dump($response->toRaw());

# convert response to a laravel collection 
var_dump($response->toCollection());
visit https://laravel.com/docs/5.3/collections for more details

# convert response to array
var_dump($response->toCollection()->toArray());

# get status code
echo RequestMan::getStatusCode();

# get content type
echo RequestMan::getContentType();

# supported clients
curl, guzzle, nategood
