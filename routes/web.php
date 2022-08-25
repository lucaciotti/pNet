<?php

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Actions\Sys\DbSeed\ZipFileUpload;
use App\Http\Controllers\sysCtrl\UserController;
use App\Http\Controllers\parideCtrl\HomeController;
use App\Http\Controllers\parideCtrl\ClientController;
use App\Http\Controllers\parideCtrl\DocCliController;
use App\Http\Controllers\parideCtrl\ProductController;
use App\Http\Controllers\parideCtrl\DocToSendController;
use App\Http\Controllers\sysCtrl\PrivacyPolicyController;
use App\Http\Controllers\parideCtrl\StatAbcProdController;
use App\Imports\PrivacyAgreementImport;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return redirect('/login');
});
require __DIR__.'/auth.php';
//Privacy Policy
Route::name('privacy::')->middleware('auth')->group(function () {
    Route::get('/privacyPolicy/{user_id}', [PrivacyPolicyController::class, 'index'])->name('index');
    Route::post('/privacyAceptance', [PrivacyPolicyController::class, 'update'])->name('update');
    Route::get('/downloadPDFprivacy', [PrivacyPolicyController::class, 'downloadPDF'])->name('downloadPDF');
    Route::get('/downloadCSVprivacy', [PrivacyPolicyController::class, 'exportCsv'])->name('downloadCSV');
    Route::post('/importCSVprivacy',[PrivacyPolicyController::class, 'importCsv'])->name('importCSV');
    Route::get('/listPrivacyAgreement', [PrivacyPolicyController::class, 'listAgreement'])->name('listPrivacyAgreement');
    Route::get('/sendMailPrivacyAgree/{id}', [PrivacyPolicyController::class, 'sendMailPrivacyAgreement'])->name('sendMailPrivacyAgree');
});

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'privacy']);

//Home Canvas
Route::name('home::')->middleware(['auth', 'privacy'])->group(function () {
    Route::get('/quotesLeft', [HomeController::class, 'leftQuotes'])->name('quotesLeft');
    Route::get('/newQuotes', [HomeController::class, 'newQuotes'])->name('newQuotes');
    Route::get('/newDDTs', [HomeController::class, 'showDDTs'])->name('newDDTs');
    Route::get('/lastInvoices', [HomeController::class, 'showInvoices'])->name('lastInvoices');
});

// Routes Clients
Route::name('client::')->middleware(['auth', 'privacy'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('list');
    Route::get('/client/{codCli}', [ClientController::class, 'detail'])->name('detail');
    Route::post('/clients/filter', [ClientController::class, 'fltIndex'])->name('fltList');
});

// Routes Products
Route::name('product::')->middleware(['auth', 'privacy'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('list');
    Route::get('/product/{codice}', [ProductController::class, 'detail'])->name('detail');
    Route::post('/products/filter', [ProductController::class, 'fltIndex'])->name('fltList');
});

// Routes Docs
Route::name('doc::')->middleware(['auth', 'privacy'])->group(function () {
    Route::get('/docs/{tipomodulo?}', [DocCliController::class, 'index'])->name('list');
    Route::get('/clidocs/{id_cli_for}/{tipomodulo?}', [DocCliController::class, 'clientList'])->name('clientList');
    Route::post('/docs/filtered', [DocCliController::class, 'fltIndex'])->name('fltList');
    Route::get('/doc/{tipodoc}/{id_doc}', [DocCliController::class, 'showDetail'])->name('detail');
    Route::get('/docPDF/{tipodoc}/{id_doc}', [DocCliController::class, 'downloadPDF'])->name('downloadPDF');
    Route::get('/ddtToSend', [DocToSendController::class, 'index'])->name('indexDdtToSend');
    Route::post('/ddtToSend', [DocToSendController::class, 'fltIndex'])->name('fltDdtToSend');
    Route::get('/ddtToSend/{id}', [DocToSendController::class, 'sendDdt'])->name('sendDdt');
});

// Routes AbcProds
Route::name('abcProds::')->middleware(['auth', 'privacy'])->group(function () {
    Route::get('/abcProds', [StatAbcProdController::class, 'index'])->name('list');
    Route::post('/abcProds/filter', [StatAbcProdController::class, 'fltIndex'])->name('fltList');
    Route::post('/abcProdToDocs', [StatAbcProdController::class, 'fromArtToDocs'])->name('artToDocs');
});


// -------------------------------------------------
//GESTIONE UTENTI
Route::name('user::')->group(function () {
    Route::resource('users', UserController::class)->middleware(['auth', 'privacy']);
    Route::get('/cli_users', [UserController::class, 'indexCli'])->name('usersCli')->middleware(['auth', 'privacy']);
    Route::get('/actLike/{id}', [UserController::class, 'actLike'])->name('actLike')->middleware(['auth', 'privacy']);
    Route::post('/user_changeDB', [UserController::class, 'changeDB'])->name('changeDB')->middleware(['auth', 'privacy']);
    Route::post('/user_changeLang', [UserController::class, 'changeSelfLang'])->name('changeLang')->middleware(['auth', 'privacy']);
    Route::get('/resetPassword/{id}', [UserController::class, 'sendResetPassword'])->name('resetPassword');
});

Route::get('pnetLogs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');

//Database Update
// Route::get('/updateDB', ZipFileUpload::class);
// Route::post('/storeDBSeedFile', ZipFileUpload::class);


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');