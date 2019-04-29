<?php
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
$api = app('Dingo\Api\Routing\Router');

$api->version(['v1'],[
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['api', 'api.throttle'],
], function ($api) {
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->post('register', 'RegisterController@register')->name('api.auth.register');
//        $api->post('login', 'LoginController@login')->name('api.auth.login');
        $api->post('login', 'AuthController@login')->name('api.auth.login');
        $api->post('logout', 'AuthController@logout')->name('api.auth.logout');
        $api->post('refresh', 'AuthController@refresh')->name('api.auth.refresh');
        $api->post('me', 'AuthController@me')->name('api.auth.me');
    });
    $api->group(['prefix' => 'lib'], function ($api) {
        $api->post('test', 'LoginController@test');
        $api->get('getExpression', 'ExpressionController@expression');
        $api->post('get', 'HeartbeatController@getGlobal')->middleware('auth:api')->name('api.lib.get');
        $api->post('ping', 'HeartbeatController@ping')->middleware('refreshToken')->name('api.lib.ping');
    });
});
