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


$app->get('/', function () use ($app) {
	return 'yanshuxin';
});


$app->group(['prefix' => 'api/v1'], function($app){
	$app->get('getShopList', 'ShopController@getShopList');
	$app->get('getShopInfo/{shopid}', 'ShopController@getShopInfo');
	
	$app->post('userLoginByCode', 'UserController@userLoginByCode');
});
