<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
//Route::get('/home/authorized-clients', 'HomeController@getAuthorizedClients')->name('authorized-clients');
//Route::get('/home/my-clients', 'HomeController@getClients')->name('personal-clients');
Route::get('/home/my-tokens', [HomeController::class, 'getTokens'])->name('personal-tokens');
Route::get('/home', [HomeController::class, 'index'])->name('personal-tokens');




Route::get('/', function () {
    return view('welcome');
})->middleware('guest');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
