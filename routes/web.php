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
    echo 'Opoops.';
});


Route::prefix('admin')
    ->group(function () {
        Route::get('/login', 'AuthController@login')->name('login');
        Route::post('/auth', 'AuthController@auth')->name('auth');
        Route::post('/logout', 'AuthController@logout')->name('logout');
    });


Route::prefix('admin')
    ->middleware('auth')
    ->name('admin.')
    ->group(function () {
        Route::get('/', 'AdminController@dashboard')->name('dashboard');

        Route::prefix('usuario')
            ->name('user.')
            ->group(function () {
                Route::get('/', 'UserController@index')->name('index');
                Route::get('/profile', 'UserController@profile')->name('profile');
                Route::put('/{user}', 'UserController@update')->name('update');
                Route::patch('/{user}', 'UserController@update')->name('update');
            });
        Route::prefix('mensagem')
            ->name('message.')
            ->group(function () {
                Route::get('/', 'MessageController@index')->name('index');
            });
        Route::prefix('documentação')
            ->name('documentation.')
            ->group(function () {
                //TODO: Ajusta, faz mais sentido em ConfigurationController
                Route::get('/', 'DocumentationController@index')->name('index');
                Route::post('/', 'DocumentationController@create')->name('create');
                Route::post('/{configuration}', 'DocumentationController@destroy')->name('destroy');
            });
        Route::prefix('datacenterinfo')
            ->name('datacenterinfo.')
            ->group(function () {
                Route::get('/', 'DatacenterInfoController@index')->name('index');
            });
    });

Route::get('/login', function () {
    return view('login');
})->name('login');


/*
 *
 * Se umidade >= 75% e < 80%
 * Umidade acima do normal
 *
 * Se umidade <=30% e > 25%
 * Umidade abaixo do normal
 *
 * Se temperatura >=25 e  < 26
 * Temperatura Acima do Normal
 *
 * Se temperatura <=15 e > 13
 * Temperatura Abaixo do Normal
 *
 * */
