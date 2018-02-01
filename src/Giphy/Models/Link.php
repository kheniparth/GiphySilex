<?php
/**
 * Created by PhpStorm.
 * Token: pkheni
 * Date: 23/01/2018
 * Time: 11:25 AM
 */

namespace GiphySilex\Models;


class Link
{
    public $id;
    public $body;
    public $user_id;
    public $created_at;
    
    CONST LINKS = [
        [
            'id' => '1',
            'body' => "body1",
            'user_id' => "10234210",
            'created_at' => "created_at1"
        ],[
            'id' => '2',
            'body' => "body2",
            'user_id' => "10234213",
            'created_at' => "created_at2"
        ],[
            'id' => '3',
            'body' => "body3",
            'user_id' => "10234211",
            'created_at' => "created_at3"
        ],[
            'id' => '4',
            'body' => "body4",
            'user_id' => "10234213",
            'created_at' => "created_at4"
        ]
    ];
    
    public function getLink($id, $uid)
    {
        $links = array_values(Link::getUserLinks($uid));
        if (isset($links[$id])) {
            return $links[$id];
        } else {
            return false;
        }
    }
    
    public function getUserLinks($id) {
        return array_filter(Link::LINKS, function($ar) use($id) {
            return ($ar['user_id'] == $id);
        });
    }
}