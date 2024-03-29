<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Api')
    ->name('api.')
    ->group(function () {
        Route::name('whatsapp.')
            ->prefix('{token}/{telephone}')
            ->group(function () {
                Route::post('/', 'WASendController@messages')->name('messages')
                    ->where(['telephone' => '[0-9]+']);
                Route::post('/send', 'WASendController@send')->name('send')
                    ->where(['telephone' => '[0-9]+']);
                Route::post('/setinvalidnumber/{message}', 'WASendController@setInvalidNumber')->name('setinvalidnumber');
                Route::post('/updatestatus/{uuid}/{status}', 'WASendController@updateStatus')->name('updatestatus');
                Route::post('/checkemail', 'WASendController@checkEmail')->name('checkemail');
            });

    });


Route::namespace('Api')
    ->name('api.')
    ->group(function () {
        Route::name('datacenter.')
            ->prefix('datacenterinfo')
            ->group(function () {
                Route::post('/last', 'DatacenterInfoController@last')->name('last');
                Route::post('/last/openticket', 'DatacenterInfoController@openTicketToLastProblem')->name('openTicket');
                Route::post('/aws/cost', 'DatacenterInfoController@awsCost')->name('openTicket');
            });
    });


