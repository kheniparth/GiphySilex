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
    $msg = "Hey There, How are you ???";
    return json_encode($msg, JSON_UNESCAPED_SLASHES);
});

$app->get('/links', function(Request $request) {
    $links = Link::LINKS;
    return json_encode($links, JSON_UNESCAPED_SLASHES);
});

$app->get('/link/{link_id}', function($link_id) use ($app) {
    $links = Link::LINKS;
    $payload = Link::getLink($link_id);
    return json_encode($payload, JSON_UNESCAPED_SLASHES);
});

$app-> run();