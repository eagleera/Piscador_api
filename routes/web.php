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
    $hola = json_decode('{"attendance":[{"payday":[{"status":"1","date":"2019-11-10"},{"status":"1","date":"2019-11-11"},{"status":"0","date":"2019-11-12"}],"worker_id":1,"worker":{"id":1,"nombre":"Trabajador prueba","ranch_id":1,"rol_id":1,"created_at":"2019-11-11 05:18:47","updated_at":"2019-11-12 04:29:32","deleted_at":null,"role":{"id":1,"nombre":"Rol prueba 1","cantidad":"12","ranch_id":1,"tipo_id":1,"created_at":"2019-11-11 05:18:24","updated_at":"2019-11-11 05:18:24","deleted_at":null,"tipo":{"id":1,"nombre":"Diario","created_at":"2019-11-11 04:01:38","updated_at":null,"deleted_at":null}}},"total":24,"cambio":[0,0,0,0,1,0,1]}],"cambio":[0,0,0,0,1,0,1],"total":25}', true);
    dd($hola["cambio"]);
    return $router->app->version();
});
//TIPOS
Route::get('/tipos', ['as'=> 'index roles', 'uses'=>'RolesController@indexTipos']);
//ROLES
Route::get('/roles', ['as'=> 'index roles', 'uses'=>'RolesController@index']);
Route::post('/rol', ['as'=> 'create new rol', 'uses'=>'RolesController@store']);
Route::patch('/rol/{id}', ['as'=> 'update a rol', 'uses'=>'RolesController@edit']);
Route::delete('/rol/{id}', ['as'=> 'delete a rol', 'uses'=>'RolesController@delete']);
//WORKERS
Route::get('/workers', ['as'=> 'index workers', 'uses'=>'WorkersController@index']);
Route::post('/worker', ['as'=> 'create new worker', 'uses'=>'WorkersController@store']);
Route::patch('/worker/{id}', ['as'=> 'update a worker', 'uses'=>'WorkersController@edit']);
Route::delete('/worker/{id}', ['as'=> 'delete a worker', 'uses'=>'WorkersController@delete']);
//ATTENDANCE
Route::get('/attendance/payday', ['as'=> 'get attendance between two dates', 'uses'=>'AttendanceController@payday']);
Route::get('/attendance/{fecha}', ['as'=> 'get attendance of one date', 'uses'=>'AttendanceController@index']);
Route::post('/attendance', ['as'=> 'post an attendance', 'uses'=>'AttendanceController@store']);
//JOURNAL
// Route::get('/journals', ['as'=> 'index journals', 'uses'=>'JournalController@index']);
// Route::post('/journal', ['as'=> 'create new journal', 'uses'=>'JournalController@store']);
// Route::patch('/journal/{id}', ['as'=> 'update a journal', 'uses'=>'JournalController@edit']);
// Route::delete('/journal/{id}', ['as'=> 'delete a journal', 'uses'=>'JournalController@delete']);
//RANCH
Route::post('/ranch', ['as'=> 'create new ranch', 'uses'=>'RanchController@store']);
Route::post('/ranch/add-invite', ['as'=> 'accept invite', 'uses'=>'RanchController@storeInvite']);
Route::post('/ranch/create-invite', ['as'=> 'generate invite', 'uses'=>'RanchController@createInvite']);
//USER
Route::post('/register', ['as'=> 'register user', 'uses'=>'AuthController@register']);
Route::post('/login', ['as'=> 'login user', 'uses'=>'AuthController@login'])->middleware('cors');
Route::get('/me', ['as'=> 'get current user', 'uses'=>'AuthController@me']);
Route::post('/logout', ['as'=> 'log out', 'uses'=>'AuthController@logout']);