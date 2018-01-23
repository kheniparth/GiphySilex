<?php
/**
 * Created by PhpStorm.
 * User: pkheni
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
            'user_id' => "user_id1",
            'created_at' => "created_at1"
        ],[
            'id' => '2',
            'body' => "body2",
            'user_id' => "user_id2",
            'created_at' => "created_at2"
        ],[
            'id' => '3',
            'body' => "body3",
            'user_id' => "user_id3",
            'created_at' => "created_at3"
        ],[
            'id' => '4',
            'body' => "body4",
            'user_id' => "user_id4",
            'created_at' => "created_at4"
        ]
    ];
    
    public function getLink($id)
    {
        foreach (Link::LINKS as $link) {
            if ($link["id"] === $id) {
                return $link;
            }
        }
        return false;
    }
}