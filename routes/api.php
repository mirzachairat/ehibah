<?php

use App\Http\Controllers\Api\DaerahController;
use App\Http\Controllers\Api\ProposalController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('kota', 'Api\DaerahController@kota');
// Route::get('chart', 'Api\HomeController@index');
// Route::get('opdchart', 'Api\HomeController@opdchart');
// Route::get('proposalopd', 'Api\HomeController@proposalopd');
// Route::get('piechart', 'Api\HomeController@piechart');
// Route::get('tahapan', 'Api\HomeController@tahapan');
// Route::get('status', 'Api\DaerahController@status');
// Route::get('kec/{id}', 'Api\DaerahController@kec');

// Route::get('kel/{id}', 'Api\DaerahController@kel');
// Route::post('daftar', 'Api\UserController@daftar');
// Route::post('login', 'Api\UserController@login');
// Route::get('pengumuman', 'Api\PengumumanController@index');
// Route::get('skpd', 'Api\SkpdController@index');
// Route::get('type', 'Api\SkpdController@type');
// Route::get('profile', 'Api\UserController@profile')->middleware('auth:api');

// Route::get('opd', 'Api\OpdController@index')->middleware('auth:api');

// Route::get('checklist/{id}', 'Api\OpdController@list')->middleware('auth:api');
// Route::get('pengajuan', 'Api\PengajuanController@index')->middleware('auth:api');
// Route::get('pengajuan/proposal/{id}', 'Api\PengajuanController@proposal')->middleware('auth:api');
// Route::post('pengajuan/store', 'Api\PengajuanController@store')->middleware('auth:api');
// Route::post('pengajuan/update/{id}', 'Api\PengajuanController@update')->middleware('auth:api');
// Route::post('pengajuan/gallery', 'Api\PengajuanController@gallery')->middleware('auth:api');
// Route::post('pengajuan/filepdf', 'Api\PengajuanController@filepdf')->middleware('auth:api');
// Route::post('pengajuan/dana', 'Api\PengajuanController@dana')->middleware('auth:api');

// Route::get('proposal', 'Api\ProposalController@index');
// Route::get('proposal/cari', 'Api\ProposalController@cari');


Route::group(['prefix' => 'v1', 'middleware' => 'api.key'], function () {
    // Route::resource('api-manager', 'ApiManagerController');
    // Route::post('api-manager/request', 'ApiManagerController@request')->name('ApiRequest');
    // Route::post('api-manager/transition', 'ApiManagerController@transition')->name('ApiTransition');
    // Route::post('api-manager/receive', 'ApiManagerController@receive')->name('ApiReceive');
    // Route::resource('host-keys', 'HostkeysController');
    // Route::get('host-keys/{hostname}/get', 'HostkeysController@get')->name('ApiHostkey');

    Route::get('kota', [DaerahController::class, 'getKota']);
    Route::get('kecamatan/{id}', [DaerahController::class, 'getKecamatan']);
    Route::get('kelurahan/{id}', [DaerahController::class, 'getKelurahan']);
    Route::get('proposal', [ProposalController::class, 'getProposal']);


});
