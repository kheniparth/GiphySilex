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
use Symfony\Component\HttpFoundation\Response;
use GiphySilex\Middleware\Authentication as Auth;

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

$app-> run();