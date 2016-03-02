<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/

Route::get('/', function()
{	
    return View::make('login');	
});

Route::post('login', 'loginController@login');


Route::get('main', 'loginController@main');
/*Route::get('main', function()
{	
    return View::make('main');

});*/

Route::get('logout', 'loginController@logout');

//Mantenimiento de Datos -> Mantenimiento de activos
Route::get('md/main', 'mantenimientosController@main');

Route::get('md/mActivos', 'mantenimientosController@mActivos');
Route::get('md/mActivos/show', 'mantenimientosController@mActivosShow');
Route::get('md/mActivos/delete', 'mantenimientosController@mActivosDelete');
Route::post('md/mActivos', 'mantenimientosController@mActivosCreateEdit');

Route::get('md/mAmenazas', 'mantenimientosController@mAmenazas');
Route::post('md/mAmenazas', 'mantenimientosController@mAmenazasCreateEdit');
Route::get('md/mAmenazas/show', 'mantenimientosController@mAmenazasShow');
Route::get('md/mAmenazas/delete', 'mantenimientosController@mAmenazasDelete');

Route::get('md/mActAmen', 'mantenimientosController@mActAmen');
Route::post('md/mActAmen', 'mantenimientosController@mActAmenEdit');
Route::get('md/mActAmen/show', 'mantenimientosController@mActAmenShow');
