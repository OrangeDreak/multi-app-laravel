<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
// use App\models\testModel;
// Route::get('/', function()
// {
// 	echo '33';
// 	$m = new testModel();
// 	$m->index();
// 	return View::make('hello');
// });
// 
// 
// 
Route::get('/', 'HomeController@showWelcome');