<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PeraturanController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ManualbookController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BackEnd\HomeController;
use App\Http\Controllers\BackEnd\LogController;
use App\Http\Controllers\BackEnd\LogLoginController;
use App\Http\Controllers\BackEnd\SkpdController;
use App\Http\Controllers\BackEnd\ProposalController as Proposal_backend;
use App\Http\Controllers\BackEnd\subController;
use App\Http\Controllers\BackEnd\WorkflowController;
use App\Http\Controllers\BackEnd\WorkflowStateController;
use App\Http\Controllers\BackEnd\WorkflowTransitionController;
use App\Http\Controllers\BackEnd\WorkflowGuardController;
use App\Http\Controllers\BackEnd\WorkflowNotificationController;
use App\Http\Controllers\BackEnd\UserController;
use App\Http\Controllers\BackEnd\PermissionController;
use App\Http\Controllers\BackEnd\RoleController;
use App\Http\Controllers\BackEnd\DataTentangController;
use App\Http\Controllers\BackEnd\DataPeraturanController;
use App\Http\Controllers\BackEnd\DataPengumumanController;
use App\Http\Controllers\BackEnd\ChecklistController;


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

// Route::get('/', function () {
    //     return view('Layouts.main');
    // });

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register']);

Route::post('/loginPost', [AuthController::class, 'loginPost'])->name('loginPost');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    //Front End  
Route::get('/about', [AboutController::class, 'index']);
Route::get('/peraturan', [PeraturanController::class, 'index']);
Route::get('/manualbook', [ManualbookController::class, 'index']);
Route::get('/proposal/myproposal', [ProposalController::class, 'myproposal'])->name('myproposal');
Route::get('/', [FrontController::class ,'index'])->name('home');
Route::get('/search', 'FrontController@search')->name('searchHome');
Route::get('/kecamatan/{id}', 'FrontController@Kecamatan');
Route::get('/rekobj/{id}', 'FrontController@rekobj');
Route::get('/kegiatan/{id}', 'FrontController@kegiatan');
Route::get('/rekrincian/{id}', 'FrontController@rekrincian');
Route::get('/sub/{id}', 'FrontController@sub');
Route::get('/kelurahan/{id}', 'FrontController@Kelurahan');

Route::get('/proposal', [ProposalController::class,'index'])->name('proposal');
Route::get('/proposal/search', 'ProposalController@search')->name('searchProposal');
Route::get('/proposal/show/{id}', 'ProposalController@show')->name('ShowProposal');
Route::get('/proposal/arsip/{id}', 'ProposalController@arsip')->name('ArsipProposal');
Route::post('/proposal/uploadPhotos', 'ProposalController@uploadPhotos');
Route::get('/proposal/{id}/delImg', 'ProposalController@delImg')->name('delImgs');
Route::post('/proposal/uploadFile', 'ProposalController@uploadFile');
Route::get('/proposal/{id}/delFile', 'ProposalController@delFile')->name('delFiles');
Route::post('/proposal/uploadFileLPJ', 'ProposalController@uploadFileLPJ');
Route::get('/proposal/{id}/delFileLPJ', 'ProposalController@delFileLPJ')->name('delFileLPJs');

Route::get('/proposal/myproposal', 'ProposalController@myproposal')->name('myproposal');
Route::get('/proposal/searchmyproposal', 'ProposalController@searchmyproposal')->name('searchMyProposal');
Route::get('/proposal/create', 'ProposalController@create')->name('createProposal');
Route::post('/proposal/store', 'ProposalController@store')->name('storeProposal');
Route::get('/proposal/edit/{id}', 'ProposalController@edit')->name('editProposal');
Route::put('/proposal/update/{id}', 'ProposalController@update')->name('updateProposal');
Route::get('/proposal/delete/{id}', 'ProposalController@destroy')->name('deleteProposal');
Route::get('/peraturan', 'PeraturanController@index')->name('peraturan');
Route::get('/pengumuman', 'PengumumanController@index')->name('pengumuman');
Route::get('/pengumuman/show/{id}', 'PengumumanController@show')->name('ShowPengumuman');
Route::get('/tentang', 'TentangController@index')->name('tentang');

Route::post('/laporan/store', 'LaporanController@store')->name('submitStore');
Route::get('/kecamatans/{id}', 'FrontController@Kecamatans');
Route::get('/kelurahans/{id}', 'FrontController@Kelurahans');

Route::get('/tabel', 'TabelController@index')->name('tabel');
Route::get('/tabel/search', 'TabelController@search')->name('searchTabel');

Route::get('/laporan', 'LaporanController@index')->name('laporan');
Route::get('/reward', 'RewardController@index')->name('reward');
Route::get('/upload/book', 'RewardController@index')->name('reward');
Route::get('/show/{id}', 'FrontController@show')->name('Show');
Route::post('/comment/{id}/edit', 'FrontController@commentSubmit')->name('commentSubmit');
Route::post('/comment/{id}/getKoment', 'FrontController@getKoment')->name('getKoment');

Route::get('/like/{id}', 'FrontController@Like')->name('Like');
Route::get('/unlike/{id}', 'FrontController@Unlike')->name('Unlike');
Route::get('/view/{id}/viewer', 'FrontController@Viewer')->name('Viewer');

Route::get('/profile', 'ProfileController@index')->name('myprofile');
Route::get('/profile/edit', 'ProfileController@edit')->name('EditMyProfile');
Route::put('/profile/update', 'ProfileController@update')->name('UpdateMyProfile');

//Back End Controller
Route::Group(['middleware'=>'auth', 'prefix' =>'admin', 'namespace' =>'backEnd'], function(){
    Route::get('/',[HomeController::class, 'index'])->name('adminHome');

    Route::get('/log', 'LogController@index')->name('log');	
	Route::get('/log-login', 'LogLoginController@index')->name('log-login');	

    Route::get('/proposals', [Proposal_backend::class, 'index'])->name('proposals');
	Route::get('/proposals/create', [ProposalController::class,'create'])->name('proposalsCreate');
	Route::get('/proposals/{id}/edit', [ProposalController::class,'edit'])->name('proposalsEdit');
	Route::get('/proposals/{id}/arsip', [ProposalController::class ,'arsip'])->name('proposalsArsip');
	Route::get('/proposals/search', [ProposalController::class,'search'])->name('proposalsSearch');
	Route::get('/proposals/{id}/show', [ProposalController::class, 'show'])->name('proposalsShow');
	Route::get('/proposals/{id}/koreksi', [ProposalController::class, 'koreksi'])->name('proposalsKoreksi');
	Route::get('/proposals/export', [ProposalController::class,'export'])->name('proposalsExport');

    //SKPD ROUTE
    Route::get('/skpd', [SkpdController::class,'index'])->name('skpd');
	Route::get('/skpd/search', [SkpdController::class,'search'])->name('SkpdSearch');
	Route::get('/skpd/create', [SkpdController::class,'create'])->name('SkpdCreate');
	Route::post('/skpd/store', [SkpdController::class,'store'])->name('SkpdStore');
	Route::get('/skpd/{id}/edit', [SkpdController::class,'edit'])->name('SkpdEdit');
	Route::get('/skpd/{id}/show', [SkpdController::class,'show'])->name('Skpd_show');
	Route::post('/skpd/{id}/update', [SkpdController::class,'update'])->name('SkpdUpdate');
	Route::get('/skpd/{id}/softdestroy', [SkpdController::class,'destroy'])->name('Skpddestroy');

	//Sub SKPD
	Route::get('/sub', [SubController::class,'index'])->name('sub');
	Route::get('/sub/search', [SubController::class,'search'])->name('SubSearch');
	Route::get('/sub/create', [SubController::class,'create'])->name('SubCreate');
	Route::post('/sub/store', [SubController::class,'store'])->name('SubStore');
	Route::get('/sub/{id}/edit', [SubController::class,'edit'])->name('SubEdit');
	Route::get('/sub/{id}/show', [SubController::class,'show'])->name('Sub_show');
	Route::post('/sub/{id}/update', [SubController::class,'update'])->name('SubUpdate');
	Route::get('/sub/{id}/softdestroy', [SubController::class,'destroy'])->name('Subdestroy');

	//Workflow
	Route::get('/workflow', [WorkflowController::class, 'index'])->name('Workflow');
	Route::get('/workflow/state', [WorkflowStateController::class, 'index'])->name('State');
	Route::get('/workflow/transition', [WorkflowTransitionController::class, 'index'])->name('Transition');
	Route::get('/workflow/guard', [WorkflowGuardController::class, 'index'])->name('Guard');
	Route::get('/workflow/notification', [WorkflowNotificationController::class, 'index'])->name('Notification');

	//User
	Route::get('/user', [UserController::class, 'index'])->name('User');
	Route::get('/user/permission', [PermissionController::class, 'index'])->name('Permission');
	Route::get('/user/role', [RoleController::class, 'index'])->name('Role');
	Route::get('/tentang', [DataTentangController::class, 'index'])->name('DataTentang');
	Route::get('/peraturan', [DataPeraturanController::class, 'index'])->name('DataPeraturan');
	Route::get('/pengumuman', [DataPengumumanController::class, 'index'])->name('DataPengumuman');
	Route::get('/checklist', [ChecklistController::class, 'index'])->name('Checklist');

});


