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

// Authentication
Route::get('/', 						'AuthController@index');
Route::get('/register', 				['as' => 'register', 	'uses' => 'AuthController@register']);
Route::post('/auth/new', 				['as' => 'login', 		'uses' => 'AuthController@create']);
Route::any('/auth/destroy', 			['as' => 'logout', 		'uses' => 'AuthController@destroy']);

// Dashboard
Route::any('/dashboard', 				['as' => 'dashboard', 	'uses' => 'DashboardController@index']);

// Economics
Route::any('/economics', 				['as' => 'economics', 	'uses' => 'EconomicsController@index']);

// Signatures
Route::get('/sig/{id}', 				'SignatureController@index');

// Help Centre
Route::any('/help', 					['as' => 'help', 		'uses' => 'HelpController@index']);
Route::any('/help/write', 				['as' => 'helpwrite', 	'uses' => 'HelpController@write']);
Route::post('/help/destroy', 			['as' => 'destroytopic','uses' => 'HelpController@destroy']);
Route::post('/help/create', 			['as' => 'createtopic', 'uses' => 'HelpController@create']);

// Pages (not worthy of controller)
Route::any('/achievements', 			['as' => 'achievements','uses' => 'PageController@achievements']);
Route::any('/highscores', 				['as' => 'highscores', 	'uses' => 'PageController@highscores']);
Route::any('/weapons', 					['as' => 'weapons', 	'uses' => 'PageController@weapons']);
Route::any('/admins', 					['as' => 'admins', 		'uses' => 'PageController@admins']);
Route::any('/seasonal', 				['as' => 'seasonal', 	'uses' => 'PageController@seasonal']);

// Admin
Route::any('/admin/stats', 				['as' => 'admin.stats', 'uses' => 'Admin\StatsController@index']);
// Admin
Route::any('/admin/feedback', 			['as' => 'admin.feedback', 'uses' => 'Admin\AdminController@feedback']);

// Admin Cash Log
Route::any('/admin/transactions/search',['as' => 'admin.trans.search', 'uses' => 'Admin\AdminController@transactionSearch']);
Route::any('/admin/transactions', 		['as' => 'admin.transactions', 'uses' => 'Admin\AdminController@transaction']);

// Admin - Player Search
Route::post('/admin/search/post', 		['as' => 'admin.player.search','uses' => 'Admin\AdminController@search']);
Route::any('/admin/search', 			['as' => 'admin.search','uses' => 'Admin\AdminController@index']);

// Admin - Player Manage
Route::any('/admin/manage', 			['as' => 'admin.manage','uses' => 'Admin\PlayerController@index']);
Route::post('/admin/manage/ban', 		['as' => 'ban', 		'uses' => 'Admin\PlayerController@ban']);
Route::post('/admin/manage/unban', 		['as' => 'unban', 		'uses' => 'Admin\PlayerController@unban']);
Route::post('/admin/manage/armyban', 	['as' => 'armyban', 	'uses' => 'Admin\PlayerController@armyban']);
Route::post('/admin/manage/unarmyban', 	['as' => 'unarmyban', 	'uses' => 'Admin\PlayerController@unarmyban']);
Route::post('/admin/manage/copban', 	['as' => 'copban', 		'uses' => 'Admin\PlayerController@copban']);
Route::post('/admin/manage/uncopban', 	['as' => 'uncopban', 	'uses' => 'Admin\PlayerController@uncopban']);
Route::post('/admin/manage/password', 	['as' => 'password', 	'uses' => 'Admin\PlayerController@password']);
Route::post('/admin/manage/jail', 		['as' => 'jail', 		'uses' => 'Admin\PlayerController@jail']);
Route::post('/admin/manage/mute', 		['as' => 'mute', 		'uses' => 'Admin\PlayerController@mute']);

// API
Route::api(['version' => 'v1', 'prefix' => 'api'], function()
{
	// Cash Statistics
	Route::get('/cashstats', 			'API\CashStatsController@totalcash');
	Route::get('/cashstats/add/{key}',	'API\CashStatsController@create');
	Route::get('/donor/reset/{key}',	'API\CashStatsController@donorReset');

	// Transactions
	Route::get('/transactions', 		'API\TransactionsController@transactions');

	// Player Data
	Route::get('/player/record/{key}',	'API\PlayerController@record');
	Route::get('/player/help/{id}', 	'API\PlayerController@article');
	Route::get('/player/feedback/{id}',	'API\PlayerController@feedbackDestroy');
	Route::get('/players',				'API\PlayerController@totalPlayers');
	Route::get('/player/{id}/{name}',	'API\PlayerController@data');
});
