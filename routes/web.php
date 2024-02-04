<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachemetsController;

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

Route::get('invoices_export/', [InvoicesController::class, 'export'])->name('invoices_export');

Route::get('invoices_report/', [Invoices_Report::class, 'index'])->name('invoices_report-index');
Route::post('invoices_reports/', [Invoices_Report::class, 'Search_invoices'])->name('invoices_report-search');

Route::get('customers_report/', [Customers_Report::class, 'index'])->name('customers_report-index');
Route::post('customers_reports/', [Customers_Report::class, 'Search_customers'])->name('customers_report-search');

// Route::get('/getProducts/{id}', [InvoicesController::class, 'getProducts']);
// Route::get('/invoicesDetails/{id}', [InvoicesDetailsController::class, 'getDetails']);

// Route::group(['middleware' => ['auth']], function () {
//     Route::resource('roles', 'RoleController');
//     Route::resource('users', 'UserController');
// });

Route::group(['middleware' => ['auth',]], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/{page}', [AdminController::class, 'index']);

// Route::resource('posts', PostController::class);

// Route::resource('/invoices', 'InvoicesController');
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



