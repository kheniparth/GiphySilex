<?php
/**
 * Created by PhpStorm.
 * User: pkheni
 * Date: 23/01/2018
 * Time: 11:24 AM
 */

namespace GiphySilex\Models;


class User
{
    public function authenticate($apikey)
    {
        //get user whose apike is this
//        $user = User::where('apikey', '=', $apikey)->take(1)->get();
        $user = new User();
        if(isset($user[0])){
            
            $this->details = $user[0];
//            return $this->details->id;
            return 1;
        }
        
        return false;
    }
}