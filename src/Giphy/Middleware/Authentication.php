<?php
/**
 * Created by PhpStorm.
 * Token: pkheni
 * Date: 23/01/2018
 * Time: 11:23 AM
 */

namespace GiphySilex\Middleware;
use GiphySilex\Models\Token;
use Firebase\FirebaseLib as Firebase;


class Authentication
{
    const GIPHYKEY = "";
    const DEFAULT_URL = 'https://giphysilex.firebaseio.com';
    const DEFAULT_TOKEN = "";
    const DEFAULT_PATH = "/";
    private $firebase;
    private $token;
    
    public function __construct() {
        $this->firebase = new Firebase(self::DEFAULT_URL, self::DEFAULT_TOKEN);
        $this->token = new Token($this->firebase);
    }
    
    public function authenticate($request, $app)
    {
        $auth = $request->headers->get("token");
        if(is_null($auth)){
            $app->abort(401);
        }
        
        $apikey = trim(substr($auth, strpos($auth, ' ')));
        $check = $this->token->authenticate($apikey);
        if((!$check) || is_null($check) || $check == "null") {
            $app->abort(401);
        } else {
            $request->attributes->set('token',$check);
        }
    }
    
    public function createToken($email, $name) {
        return $this->token->createToken($email, $name);
    }
}