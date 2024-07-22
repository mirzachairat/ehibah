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

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::get('/register', 'register');
    Route::post('/loginPost', 'loginPost')->name('loginPost');
    Route::get('/logout', 'logout')->name('logout');
});

// Front End  
Route::controller(AboutController::class)->group(function () {
    Route::get('/about', 'index');
});

Route::controller(PeraturanController::class)->group(function () {
    Route::get('/peraturan', 'index');
});

Route::controller(ManualbookController::class)->group(function () {
    Route::get('/manualbook', 'index');
});

Route::controller(ProposalController::class)->group(function () {
    Route::get('/proposal/myproposal', 'myproposal')->name('myproposal');
    Route::get('/proposal', 'index')->name('proposal');
    Route::get('/proposal/search', 'search')->name('searchProposal');
    Route::get('/proposal/show/{id}', 'show')->name('ShowProposal');
    Route::get('/proposal/arsip/{id}', 'arsip')->name('ArsipProposal');
    Route::post('/proposal/uploadPhotos', 'uploadPhotos');
    Route::get('/proposal/{id}/delImg', 'delImg')->name('delImgs');
    Route::post('/proposal/uploadFile', 'uploadFile');
    Route::get('/proposal/{id}/delFile', 'delFile')->name('delFiles');
    Route::post('/proposal/uploadFileLPJ', 'uploadFileLPJ');
    Route::get('/proposal/{id}/delFileLPJ', 'delFileLPJ')->name('delFileLPJs');
    Route::get('/proposal/searchmyproposal', 'searchmyproposal')->name('searchMyProposal');
    Route::get('/proposal/create', 'create')->name('createProposal');
    Route::post('/proposal/store', 'store')->name('storeProposal');
    Route::get('/proposal/edit/{id}', 'edit')->name('editProposal');
    Route::put('/proposal/update/{id}', 'update')->name('updateProposal');
    Route::get('/proposal/delete/{id}', 'destroy')->name('deleteProposal');
});

Route::controller(FrontController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/search', 'search')->name('searchHome');
    Route::get('/kecamatan/{id}', 'Kecamatan');
    Route::get('/rekobj/{id}', 'rekobj');
    Route::get('/kegiatan/{id}', 'kegiatan');
    Route::get('/rekrincian/{id}', 'rekrincian');
    Route::get('/sub/{id}', 'sub');
    Route::get('/kelurahan/{id}', 'Kelurahan');
    Route::get('/pengumuman', 'pengumuman')->name('pengumuman');
    Route::get('/pengumuman/show/{id}', 'show')->name('ShowPengumuman');
    Route::get('/tentang', 'tentang')->name('tentang');
    Route::get('/kecamatans/{id}', 'Kecamatans');
    Route::get('/kelurahans/{id}', 'Kelurahans');
    Route::get('/tabel', 'tabel')->name('tabel');
    Route::get('/tabel/search', 'search')->name('searchTabel');
    Route::get('/laporan', 'index')->name('laporan');
    Route::get('/reward', 'index')->name('reward');
    Route::get('/upload/book', 'index')->name('reward');
    Route::get('/show/{id}', 'show')->name('Show');
    Route::post('/comment/{id}/edit', 'commentSubmit')->name('commentSubmit');
    Route::post('/comment/{id}/getKoment', 'getKoment')->name('getKoment');
    Route::get('/like/{id}', 'Like')->name('Like');
    Route::get('/unlike/{id}', 'Unlike')->name('Unlike');
    Route::get('/view/{id}/viewer', 'Viewer')->name('Viewer');
    Route::get('/profile', 'index')->name('myprofile');
    Route::get('/profile/edit', 'edit')->name('EditMyProfile');
    Route::put('/profile/update', 'update')->name('UpdateMyProfile');
});

//Back End Controller
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('adminHome');
    });

    Route::controller(LogController::class)->group(function () {
        Route::get('/log', 'index')->name('log');
    });

    Route::controller(LogLoginController::class)->group(function () {
        Route::get('/log-login', 'index')->name('log-login');
    });

    Route::controller(Proposal_backend::class)->group(function () {
        Route::get('/proposals', 'index')->name('proposals');
        Route::get('/proposals/create', 'create')->name('proposalsCreate');
        Route::get('/proposals/{id}/edit', 'edit')->name('proposalsEdit');
        Route::get('/proposals/{id}/arsip', 'arsip')->name('proposalsArsip');
        Route::get('/proposals/search', 'search')->name('proposalsSearch');
        Route::get('/proposals/{id}/show', 'show')->name('proposalsShow');
        Route::get('/proposals/{id}/koreksi', 'koreksi')->name('proposalsKoreksi');
        Route::get('/proposals/export', 'export')->name('proposalsExport');
    });

    //SKPD ROUTE
    Route::controller(SkpdController::class)->group(function () {
        Route::get('/skpd', 'index')->name('skpd');
        Route::get('/skpd/search', 'search')->name('SkpdSearch');
        Route::get('/skpd/create', 'create')->name('SkpdCreate');
        Route::post('/skpd/store', 'store')->name('SkpdStore');
        Route::get('/skpd/{id}/edit', 'edit')->name('SkpdEdit');
        Route::get('/skpd/{id}/show', 'show')->name('Skpd_show');
        Route::post('/skpd/{id}/update', 'update')->name('SkpdUpdate');
        Route::get('/skpd/{id}/softdestroy', 'destroy')->name('Skpddestroy');
    });

    //Sub SKPD
    Route::controller(SubController::class)->group(function () {
        Route::get('/sub', 'index')->name('sub');
        Route::get('/sub/search', 'search')->name('SubSearch');
        Route::get('/sub/create', 'create')->name('SubCreate');
        Route::post('/sub/store', 'store')->name('SubStore');
        Route::get('/sub/{id}/edit', 'edit')->name('SubEdit');
        Route::get('/sub/{id}/show', 'show')->name('Sub_show');
        Route::post('/sub/{id}/update', 'update')->name('SubUpdate');
        Route::get('/sub/{id}/softdestroy', 'destroy')->name('Subdestroy');
    });

    //Workflow
    Route::controller(WorkflowController::class)->group(function () {
        Route::get('/workflow', 'index')->name('Workflow');
        Route::get('/workflow/state', 'index')->name('State');
        Route::get('/workflow/transition', 'index')->name('Transition');
        Route::get('/workflow/guard', 'index')->name('Guard');
        Route::get('/workflow/notification', 'index')->name('Notification');
    });

    //User
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('User');
        Route::get('/user/permission', 'index')->name('Permission');
        Route::get('/user/role', 'index')->name('Role');
    });

    Route::controller(DataTentangController::class)->group(function () {
        Route::get('/tentang', 'index')->name('DataTentang');
    });

    Route::controller(DataPeraturanController::class)->group(function () {
        Route::get('/peraturan', 'index')->name('DataPeraturan');
    });

    Route::controller(DataPengumumanController::class)->group(function () {
        Route::get('/pengumuman', 'index')->name('DataPengumuman');
    });

    Route::controller(ChecklistController::class)->group(function () {
        Route::get('/checklist', 'index')->name('Checklist');
    });
});

