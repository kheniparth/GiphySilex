<?php
/**
 * Created by PhpStorm.
 * Token: pkheni
 * Date: 23/01/2018
 * Time: 11:24 AM
 */

namespace GiphySilex\Models;
use Firebase\FirebaseLib as Firebase;
use GiphySilex\Middleware\Authentication;


class Token
{
    private $firebase;
    private $timezone;
    const PATH = "/tokens/";
    
    public function __construct(Firebase $firebase)
    {
        $this->firebase = $firebase;
        $this->timezone = new \DateTimeZone("America/Toronto");
    }
    
    public function authenticate($apikey)
    {
        $token = $this->firebase->get(Authentication::DEFAULT_PATH . self::PATH . $apikey);
        if (is_null($token) || empty($token) || $token == "null") {
            return false;
        }
        if ($this->validateToken($token)) {
            return $token;
        } else {
            return false;
        }
    }
    
    private function validateToken($token)
    {
        $token = json_decode($token);
        $currentTime = new \DateTime(
            'now',
            $this->timezone
        );
        $endTime = date_create_from_format("YmdHis", $token->end_time);
        $endTime->setTimezone($this->timezone);
        if ($currentTime > $endTime) {
            $flag = false;
        } else {
            $flag = true;
        }
        return $flag;
    }
    
    private function generateToken($length = 8) {
        $numbers = "0123456789";
        $lower = "abcdefghijklmnopqrstuvwxyz";
        $upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $special = "!#$%^*";
        $lib = $numbers . $lower . $upper . $special;
        $libLength = strlen($lib);
        $token = "";
        while ($length > 0) {
            $token .= $lib[mt_rand(0, $libLength) - 1];
            $length--;
        }
        $currentTime = new \DateTime(
            'now',
            new \DateTimeZone("America/Toronto")
        );
        //P1D = plus 1 day
        $endTime = $currentTime->add(new \DateInterval('P1D'));
        return [
            "token" => $token,
            "start_time" => $currentTime->format('YmdHis'),
            "end_time" => $endTime->format('YmdHis')
        ];
    }
    
    public function createToken($email, $name) {
        $token = $this->generateToken();
        $token["email"] = $email;
        $token["name"] = $name;
        return $this->firebase->set(
            Authentication::DEFAULT_PATH . self::PATH . $token["token"],
            $token
        );
    }
}