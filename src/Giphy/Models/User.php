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
    const USERS = [
        [
            'id' => '10234213',
            'authToken' => '2093028390429034902040230480',
            'name' => 'Parth Kheni'
        ]
    ];
    
    public function authenticate($apikey)
    {
        //get user whose apike is this
        foreach (User::USERS as $index => $user) {
            if ($user['authToken'] === $apikey){
                return $user['id'];
            }
        }
        
        return false;
    }
}