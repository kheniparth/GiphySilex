<?php
/**
 * Created by PhpStorm.
 * Token: pkheni
 * Date: 23/01/2018
 * Time: 11:18 AM
 */

require '../vendor/autoload.php';

use GiphySilex\Models\Token;
use Symfony\Component\HttpFoundation\Request;
use GiphySilex\Middleware\Authentication;
use GPH\Api\DefaultApi as Giphy;


$app = new Silex\Application();
$auth = new Authentication();

//runs before each request made to API
$app->before(function($request, $app) use ($auth) {
    $route = $request->get("_route");
    //skip authentication if user wants to create new token
    if ($route != "POST_create" ) {
        $auth->authenticate($request, $app);
    }
});

//home page
$app->get('/', function(Request $request) {
    $token = json_decode($request->attributes->get('token'));
    $name = empty($token->name) ? "there" : $token->name;
    $msg = "Hey {$name}, How are you ???";
    return json_encode($msg, JSON_UNESCAPED_SLASHES);
});

//allows user to create new token and accepts valid email and optional name
$app->post('/create', function (Request $request) use ($auth) {
    $email = trim($request->get('email'));
    $name = str_replace(" ", "", trim($request->get('name')));
    
    //validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $auth->createToken($email, $name);
    } else {
        return json_encode(
            "Please provide valid email address.",
            JSON_UNESCAPED_SLASHES
        );
    }
});

//makes request to GIPHY api to search what user has passed as search_str
$app->get('/search/{search_str}', function(Request $request, $search_str) use ($app) {
    $api_instance = new Giphy();
    $api_key = Authentication::GIPHYKEY; // string | Giphy API Key.
    $q = trim($search_str); // string | Search query term or prhase.
    $limit = 25; // int | The maximum number of records to return.
    $offset = 0; // int | An optional results offset. Defaults to 0.
    $rating = "g"; // string | Filters results by specified rating.
    $lang = "en"; // string | Specify default country for regional content; use a 2-letter ISO 639-1 country code. See list of supported languages <a href = \"../language-support\">here</a>.
    $fmt = "json"; // string | Used to indicate the expected response format. Default is Json.
    
    try {
        $payload = $api_instance->gifsSearchGet($api_key, $q, $limit, $offset, $rating, $lang, $fmt);
        return $payload;
    } catch (Exception $e) {
        return json_encode(
            'Exception when calling DefaultApi->gifsSearchGet: ' . $e->getMessage(),
            JSON_UNESCAPED_SLASHES
        );
    }
});

$app-> run();