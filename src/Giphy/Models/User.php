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
            'authToken' => 'parth',
            'name' => 'Parth Kheni'
        ], [
            'id' => '10234214',
            'authToken' => 'swapna',
            'name' => 'Swapna Kheni'
        ], [
            'id' => '10234215',
            'authToken' => 'jayvijay',
            'name' => 'Jayvijay Gohil'
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