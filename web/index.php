<?php
/**
 * Created by PhpStorm.
 * User: pkheni
 * Date: 23/01/2018
 * Time: 11:18 AM
 */

require 'vendor/autoload.php';

use GiphySilex\Models\Link;
use GiphySilex\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GiphySilex\Middleware\Authentication as Auth;

$app = new Silex\Application();

$app->before(function($request, $app) {
    Auth::authenticate($request, $app);
});

$app-> run();