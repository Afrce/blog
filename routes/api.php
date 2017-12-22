<?php

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api=app('Dingo\Api\Routing\Router');
$api->version('v1',['namespace'=>'App\Http\Controllers\Api'],function ($api) {
    $api->get('reg', 'ApiController@getReg');
    $api->get('login', 'ApiController@getLogin');
    $api->get('index',"ApiController@getIndex");
    $api->get('getToken','ApiController@getToken');
    $api->get('comment','ApiController@getComment');
    $api->get('article','ApiController@getArticle');
    $api->group(['middleware'=>'getFormToken'], function ($api) {
        $api->get('addComment','ApiController@getAddComment');
        $api->post('addArticle','ApiController@postAddArticle');
    });
});
