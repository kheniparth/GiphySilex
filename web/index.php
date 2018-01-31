<?php
/**
 * Created by PhpStorm.
 * User: pkheni
 * Date: 23/01/2018
 * Time: 11:18 AM
 */

require '../vendor/autoload.php';

use GiphySilex\Models\Link;
use GiphySilex\Models\User;
use Symfony\Component\HttpFoundation\Request;
use GPH\Api\DefaultApi as Giphy;

$app = new Silex\Application();

$app->before(function($request, $app) {
//    Auth::authenticate($request, $app);
    $auth = $request->headers->get("Authorization");
    $apikey = substr($auth, strpos($auth, ' '));
    $apikey = trim($apikey);
    $user = new User();
    $check = $user->authenticate($apikey);
    
    if(!$check){
        $app->abort(401);
    } else {
        $request->attributes->set('userid',$check);
    }
});

$app->get('/', function(Request $request) {
    $userId = $request->attributes->get('userid');
    $key = array_search($userId, array_column(User::USERS, "id"));
    $user = User::USERS[$key];
    $name = $user["name"];
    $msg = "Hey {$name}, How are you ???";
    return json_encode($msg, JSON_UNESCAPED_SLASHES);
});

$app->get('/links', function(Request $request) {
    $userId = $request->attributes->get('userid');
    $links = Link::getUserLinks($userId);
    return json_encode($links, JSON_UNESCAPED_SLASHES);
});

$app->get('/link/{link_id}', function(Request $request) {
    $link_id = $request->get('link_id');
    $userId = $request->attributes->get('userid');
    $payload = Link::getLink($link_id, $userId);
    return json_encode($payload, JSON_UNESCAPED_SLASHES);
});

$app->get('/search/{search_str}', function(Request $request) {
    $userId = $request->attributes->get('userid');
    
    $api_instance = new Giphy();
    $api_key = "GIPHYAPIKEY"; // string | Giphy API Key.
    $q = trim($request->get('search_str')); // string | Search query term or prhase.
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