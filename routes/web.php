<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/reversi/random', 'ReversiController@playRandom');
$router->post('/reversi/maxscore', 'ReversiController@playMaxScore');

$router->options('/reversi/random', function() {

    return response(json_encode([
        'methods-allowed' => ['POST', 'GET', 'OPTIONS'],
    ]), 200)
        ->header('Access-Control-Allow-Headers', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');

});


$router->options('/reversi/maxscore', function() {

    return response(json_encode([
        'methods-allowed' => ['POST', 'GET', 'OPTIONS'],
    ]), 200)
        ->header('Access-Control-Allow-Headers', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');

});
