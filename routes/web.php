<?php

use App\Http\Controllers\InvoicesAttachemetsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceArchiveController;
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
Route::resource('InvoiceAchiveController', InvoiceArchiveController::class);

Route::resource('sections', SectionsController::class);

Route::resource('products', ProductsController::class);




Route::get('viewAttachment/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'viewAttachment']);
Route::get('downloadAttachment/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'downloadAttachment']);
Route::post('deleteAttachment', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');


Route::get('/Print_invoice/{id}', [InvoicesController::class, 'Print_invoice']);
Route::get('/section/{id}', [InvoicesController::class, 'getProducts']);
Route::get('/Status_show/{id}', [InvoicesController::class, 'Status_show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');

Route::get('/invoices_paid', [InvoicesController::class, 'invoices_paid'])->name('invoices_paid');
Route::get('/invoices_partiallyPaid', [InvoicesController::class, 'invoices_partiallyPaid'])->name('invoices_partiallyPaid');
Route::get('/invoices_unpaid', [InvoicesController::class, 'invoices_unpaid'])->name('invoices_unpaid');
Route::post('/archive_invoice', [InvoicesController::class, 'archiveInvoice'])->name('archive_invoice');



// Route::get('/getProducts/{id}', [InvoicesController::class, 'getProducts']);
// Route::get('/invoicesDetails/{id}', [InvoicesDetailsController::class, 'getDetails']);

Route::get('/{page}', [AdminController::class, 'index']);

// Route::resource('posts', PostController::class);

// Route::resource('/invoices', 'InvoicesController');
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
