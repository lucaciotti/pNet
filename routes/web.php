<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\parideCtrl\ClientController;
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
    return view('welcome');
});

require __DIR__.'/auth.php';

// Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');


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