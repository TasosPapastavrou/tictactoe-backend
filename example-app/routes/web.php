<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//ta urls gia na kanw kanw tis klisis mou 
Route::get('/showlastgame',[App\Http\Controllers\GameC::class,'showLastGame']);
Route::post('/addmove/{id}',[App\Http\Controllers\GameC::class,'domove']);
Route::get('/startgame/{id}',[App\Http\Controllers\GameC::class,'StarTheGame']);
Route::post('/creategame',[App\Http\Controllers\GameC::class,'CreateGame']);
 
