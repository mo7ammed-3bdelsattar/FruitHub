<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\DriverController;
use App\Http\Controllers\Dashboard\SearchController;
use App\Http\Controllers\Dashboard\AddressController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    return view('welcome');
});


Route::middleware('auth.admin')->prefix('dashboard')->as('dashboard.')->group(function () {
    Route::get('/home', HomeController::class)->name('index');
    Route::get('/search', SearchController::class)->name('search');
    Route::resource('/users', UserController::class);
    Route::get('users/{userId}/roles', [UserController::class, 'addRole'])->name('users.role');
    Route::post('users/{userId}/roles', [UserController::class, 'assignRole'])->name('users.role.assign');
    Route::resource('/drivers', DriverController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/addresses', AddressController::class);
    Route::resource('/cities', CityController::class);
    Route::get('users/{id}/addresses', [AddressController::class, 'show'])->name('users.addresses');


    Route::controller(AddressController::class)->prefix('/addresses')->as('addresses.')->group(function () {
        Route::get('/user/{id}', 'create')->name('user.create');
        Route::post('/user/{id}', 'store')->name('user.store');
    });
    
    Route::resource('/orders', OrderController::class);
    Route::controller(OrderController::class)->prefix('/orders')->as('orders.')->group(function () {
        Route::get('/{id}/invoice', 'invoice')->name('invoice');
        Route::get('/{id}/invoice/print', 'invoicePdf')->name('invoice.pdf');
        Route::delete('/{orderId}/product/{productId}', 'deleteItem')->name('item.delete');
    });
    Route::controller(SettingController::class)->prefix('/settings')->as('settings.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', action: 'update')->name('update');
    });
    Route::controller(ProfileController::class)->prefix('/profile')->as('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', action: 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
        Route::patch('/image', 'updateImage')->name('updateImage');
        Route::delete('/image', 'destroyImage')->name('destroyImage');
    });
});

Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment-failed', [PaymentController::class, 'failed'])->name('payment.failed');

require __DIR__ . '/auth.php';
