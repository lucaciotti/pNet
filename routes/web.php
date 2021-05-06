<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Actions\Sys\DbSeed\ZipFileUpload;
use App\Http\Controllers\sysCtrl\UserController;
use App\Http\Controllers\parideCtrl\ClientController;
use App\Http\Controllers\parideCtrl\DocCliController;
use App\Http\Controllers\parideCtrl\HomeController;
use App\Http\Controllers\parideCtrl\ProductController;

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
    // return view('welcome');
    return redirect('/login');
});

require __DIR__.'/auth.php';

// Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');


// Routes Clients
Route::name('client::')->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('list');
    Route::get('/client/{codCli}', [ClientController::class, 'detail'])->name('detail');
    Route::post('/clients/filter', [ClientController::class, 'fltIndex'])->name('fltList');
});

// Routes Products
Route::name('product::')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('list');
    Route::get('/product/{codice}', [ProductController::class, 'detail'])->name('detail');
    Route::post('/products/filter', [ProductController::class, 'fltIndex'])->name('fltList');
});

// Routes Docs
Route::name('doc::')->group(function () {
    Route::get('/docs/{tipomodulo?}', [DocCliController::class, 'index'])->name('list');
    Route::get('/docs/{tipodoc}/{id_doc}', [DocCliController::class, 'showDetail'])->name('detail');
});



//GESTIONE UTENTI
Route::name('user::')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/cli_users', [UserController::class, 'indexCli'])->name('usersCli');
    Route::get('/actLike/{id}', [UserController::class, 'actLike'])->name('actLike');
    Route::post('/user_changeDB', [UserController::class, 'changeDB'])->name('changeDB');
    Route::post('/user_changeLang', [UserController::class, 'changeSelfLang'])->name('changeLang');
});

//Database Update
// Route::get('/updateDB', ZipFileUpload::class);
// Route::post('/storeDBSeedFile', ZipFileUpload::class);