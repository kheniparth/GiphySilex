<?php
/**
 * Created by PhpStorm.
 * User: pkheni
 * Date: 23/01/2018
 * Time: 11:23 AM
 */

namespace GiphySilex\Middleware;
use GiphySilex\Models\User;


class Authentication
{
    public function authenticate($request, $app)
    {
        
        $auth = $request->headers->get("Authorization");
        $apikey = substr($auth, strpos($auth, ' '));
        $apikey = trim($apikey);
        $user = new User();
        $check = $user->authenticate($apikey);

        if(!$check){
            $app->abort(401);
        }
        
        else $request->attributes->set('userid',$check);
        
    }
}