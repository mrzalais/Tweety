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

$namespace = 'App\Http\Controllers\\';

Route::middleware('auth')->group(function () {
    $namespace = 'App\Http\Controllers\\';
    Route::get('/tweets', $namespace . 'TweetsController@index')->name('home');
    Route::post('/tweets', $namespace . 'TweetsController@store');

    Route::post('/tweets/{tweet}/like', $namespace . 'TweetLikesController@store');
    Route::delete('/tweets/{tweet}/like', $namespace . 'TweetLikesController@destroy');

    Route::post(
        '/profiles/{user:username}/follow',
        $namespace . 'FollowsController@store'
    )->name('follow');

    Route::get(
        '/profiles/{user:username}/edit',
        $namespace . 'ProfilesController@edit'
    )->middleware('can:edit,user');

    Route::patch(
        '/profiles/{user:username}',
        $namespace . 'ProfilesController@update'
    )->middleware('can:edit,user');

    Route::get('/explore', $namespace . 'ExploreController');

});

Route::get('/profiles/{user:username}', $namespace . 'ProfilesController@show')->name('profile');




Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
