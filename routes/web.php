<?php

use App\Http\Controllers\InvoicesAttachemetsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoicesDetailsController;

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



Route::get('/', function () {
    return view(view: 'auth.login');
});

// Route::get('/page', 'AdminController@index');

Auth::routes();
// Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('invoices', InvoicesController::class);

Route::resource('invoicesDetails', InvoicesDetailsController::class);
Route::resource('invoicesAttachement', InvoicesAttachemetsController::class);
Route::get('viewAttachment/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'viewAttachment']);
Route::get('downloadAttachment/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'downloadAttachment']);
Route::post('deleteAttachment', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

Route::resource('sections', SectionsController::class);
Route::get('/section/{id}', [InvoicesController::class, 'getProducts']);
Route::get('/Status_show/{id}', [InvoicesController::class, 'Status_show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');
// Route::get('/getProducts/{id}', [InvoicesController::class, 'getProducts']);
// Route::get('/invoicesDetails/{id}', [InvoicesDetailsController::class, 'getDetails']);
Route::resource('products', ProductsController::class);

Route::get('/{page}', [AdminController::class, 'index']);

// Route::resource('posts', PostController::class);

// Route::resource('/invoices', 'InvoicesController');
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
