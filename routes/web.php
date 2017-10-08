<?php
	use Illuminate\Http\Request;
	use Dingo\Api\Routing\Router;
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

//$router->get('/', function () use ($router) {
//  return $router->app->version();
//});

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// options请求就只需要输出头部信息就OK了。
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // finish preflight CORS requests here
}

$app->get('/', function () use ($app) {
	return 'yanshuxin';
});


$app->group(['prefix' => 'api/v1'], function($app){
	$app->get('getShopList', 'ShopController@getShopList');
	$app->get('getShopInfo/{shopid}', 'ShopController@getShopInfo');
	
	$app->post('userLoginByCode', 'UserController@userLoginByCode');
	$app->post('userLoginByAccount', 'UserController@userLoginByAccount');
});
