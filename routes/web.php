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


$router->group(['prefix' => "item"], function() use ($router) {
    $router->post("add", ["uses" => "ItemController@add"]);
    $router->get("delete/{uuid}", ["uses" => "ItemController@delete"]);
    $router->get("complete/{uuid}", ["uses" => "ItemController@complete"]);
    $router->get("incomplete/{uuid}", ["uses" => "ItemController@incomplete"]);

    $router->group(['prefix' => "list"], function() use ($router) {
        $router->get("incomplete", ["uses" => "ItemController@incompleteList"]);
        $router->get("completed", ["uses" => "ItemController@completedList"]);
    });


});

